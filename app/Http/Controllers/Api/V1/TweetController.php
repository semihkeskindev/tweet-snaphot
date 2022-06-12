<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TweetResource;
use App\Rules\CheckTweetUrl;
use App\Services\TwitterService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TweetController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'tweet_url' => [
                'bail',
                'required',
                'url',
                new CheckTweetUrl(),
            ]
        ]);

        $tweetUrl = $request->get('tweet_url');

        /** @var TwitterService $twitterService */
        $twitterService = app(TwitterService::class);

        $tweetId = $twitterService->getTweetIdFromTweetUrl($tweetUrl);

        try {
            $tweet = $twitterService->getTweetById($tweetId);
        } catch (\Exception $e) {
            throw ValidationException::withMessages(['tweet_url' => 'Tweet linkini eksik veya hatalı girdiniz. Tweet linkinin doğru ve geçerli olduğundan emin olunuz.']);
        }

        return new TweetResource($tweet);
    }
}
