<?php

namespace App\Services;

class TwitterService
{
    protected string $disk = 'public';

    public function checkTweetLinkFormat(string $tweetLinkFormat)
    {

    }

    public function getTweetById(int $id)
    {
        if ($this->isTweetAlreadyRequestedBefore($id)) {
            return json_decode(\Storage::disk($this->disk)->get($this->getTweetStorageJsonFileName($id)), true);
        }

        // $result string json değeri tutuyor.
        $result = \Twitter::getTweet($id, [
            'expansions' => 'attachments.media_keys,attachments.poll_ids,author_id,geo.place_id,entities.mentions.username,referenced_tweets.id,in_reply_to_user_id,referenced_tweets.id.author_id',
            'media.fields' => 'public_metrics,type,promoted_metrics,preview_image_url,non_public_metrics,variants,width,url,alt_text,duration_ms,height,organic_metrics,media_key',
            'poll.fields' => 'voting_status,options,id,end_datetime,duration_minutes',
            'user.fields' => 'pinned_tweet_id,protected,username,verified,public_metrics,withheld,profile_image_url,url,location,id,name,entities,description,created_at',
            'place.fields' => 'contained_within,name,place_type,id,geo,full_name,country,country_code',
        ]);

        $tweetDetail = json_decode($result, true);

        if (array_key_exists('errors', $tweetDetail)) {
            throw new \Exception($result, 404);
        }

        \Storage::disk($this->disk)->put($this->getTweetStorageJsonFileName($id), json_encode($tweetDetail));

        return $tweetDetail;
    }

    private function isTweetAlreadyRequestedBefore(int $id): bool
    {
        return \Storage::disk($this->disk)->exists($this->getTweetStorageJsonFileName($id));
    }

    private function getTweetStorageJsonFileName(int $id)
    {
        return 'tweet-'.$id.'.json';
    }
}
