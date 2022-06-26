<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;

class TwitterController extends Controller
{
    public function show(Tweet $tweet)
    {
        // todo: tweete erişenlerin user agent bilgisini tut.
        return view('tweets.show')->with([
            'tweet' => $tweet
        ]);
    }
}
