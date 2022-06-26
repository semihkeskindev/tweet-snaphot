<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class TwitterController extends Controller
{
    public function lastSavedTweets()
    {
        /** @var User $user */
        $user = auth()->user();

        $tweets = $user->tweets()
            ->latest()
            ->paginate(10);

        return view('profile.last-saved-tweets')->with([
            'tweets' => $tweets,
        ]);
    }
}
