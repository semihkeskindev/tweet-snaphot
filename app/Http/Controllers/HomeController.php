<?php

namespace App\Http\Controllers;

use App\Http\Resources\TweetResource;
use App\Models\Tweet;
use App\Rules\CheckTweetUrl;
use App\Services\TwitterService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    public function index()
    {
        $lastTweets = Tweet::query()
            ->limit(5)
            ->latest()
            ->get();

        return view('home')->with([
            'lastTweets' => $lastTweets,
        ]);
    }

    public function searchTweet(Request $request)
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

        return redirect()->back()->with('savedSuccessTweet', $tweet);
    }
}
