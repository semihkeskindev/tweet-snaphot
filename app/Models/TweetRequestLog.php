<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TweetRequestLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'tweet_id' => 'integer',
        'response' => 'json',
        'status_code' => 'integer',
    ];
}
