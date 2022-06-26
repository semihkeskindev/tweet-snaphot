<?php

namespace App\Services;

use App\Jobs\LogTweetRequestJob;
use App\Models\Tweet;
use App\Models\User;
use App\Utils\Helper;
use Atymic\Twitter\Exception\ClientException as TwitterClientException;
use function PHPUnit\Framework\throwException;

class TwitterService
{
    protected string $disk = 'local';

    protected string $tweetLinkRegex = '#https?://twitter\.com/(?:\#!/)?(\w+)/status(es)?/(\d+)#is';

    public function getTweetIdFromTweetUrl(string $tweetLinkFormat): int | false
    {
        if (!filter_var($tweetLinkFormat, FILTER_VALIDATE_URL)) {
            logger("Tweet link formatı yanlış (1): ".$tweetLinkFormat);
            return false;
        }

        $parsedTweetUrl = parse_url($tweetLinkFormat);

        if (!$parsedTweetUrl) {
            logger("Tweet link formatı yanlış (2): ".$tweetLinkFormat);
            return false;
        }

        unset($parsedTweetUrl['query']);
        unset($parsedTweetUrl['fragment']);

        $unparsedTweetUrl = Helper::unparseUrl($parsedTweetUrl);

        if (!filter_var($unparsedTweetUrl, FILTER_VALIDATE_URL)) {
            logger("Tweet link formatı yanlış (3): ".$tweetLinkFormat);
            return false;
        }

        if (!preg_match($this->tweetLinkRegex, $unparsedTweetUrl, $matchTweetUrlResults)) {
            return false;
        }

        $tweetId = $matchTweetUrlResults[3] ?? null;

        if (!is_numeric($tweetId)) {
            return false;
        }

        return (int) $tweetId;
    }

    public function getTweetById(int $id): Tweet
    {
        /** @var Tweet $tweet */
        $tweet = Tweet::query()->where('tweet_id', $id)->first();

        if ($tweet) {
            $this->saveTweetSavingRequestOfUser($tweet->id, auth()->id());

            return $tweet;
        }

        // $result string json değeri tutuyor.
        try {
            $result = \Twitter::getTweet($id, [
                'expansions' => 'attachments.media_keys,attachments.poll_ids,author_id,geo.place_id,entities.mentions.username,referenced_tweets.id,in_reply_to_user_id,referenced_tweets.id.author_id',
                'media.fields' => 'public_metrics,type,promoted_metrics,preview_image_url,non_public_metrics,variants,width,url,alt_text,duration_ms,height,organic_metrics,media_key',
                'poll.fields' => 'voting_status,options,id,end_datetime,duration_minutes',
                'user.fields' => 'pinned_tweet_id,protected,username,verified,public_metrics,withheld,profile_image_url,url,location,id,name,entities,description,created_at',
                'place.fields' => 'contained_within,name,place_type,id,geo,full_name,country,country_code',
            ]);
        } catch (TwitterClientException $e) {
            //dispatch(new LogTweetRequestJob($id))
            logger('TwitterClientException: ', [$e]);
            throw new TwitterClientException($e);
        }

        $tweetDetail = json_decode($result, true);

        if (array_key_exists('errors', $tweetDetail)) {
            logger('$tweetDetail array key exists errors: ', [$tweetDetail]);
            throw new \Exception($result, 404);
        }

        $tweet = $this->saveTweetData($id, 'getTweet', $tweetDetail);

        $this->saveTweetSavingRequestOfUser($tweet->id, auth()->id());

        return $tweet;
    }

    private function isTweetAlreadyRequestedBefore(int $id): bool
    {
        return \Storage::disk($this->disk)->exists($this->getTweetStorageJsonFileName($id));
    }

    private function getTweetStorageJsonFileName(int $id)
    {
        return 'tweet-'.$id.'.json';
    }

    private function saveTweetSavingRequestOfUser(int $tweetId, int $userId)
    {
        /** @var User $user */
        $user = User::query()->find($userId);

        $user->tweets()->syncWithoutDetaching([$tweetId]);
    }

    private function saveTweetData(int $tweetId, string $requestMethodName, array $data): Tweet
    {
        $tweet = new Tweet();
        $tweet->tweet_id = $tweetId;
        $tweet->user_id = auth()->id();
        $tweet->request_method_name = $requestMethodName;
        $tweet->data = $data;
        $tweet->save();

        return $tweet;
    }
}
