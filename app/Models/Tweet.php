<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'tweet_id' => 'integer',
        'data' => 'json',
    ];

    protected $appends = [
        'description',
        'author',
        'details',
    ];

    public function getAuthorAttribute()
    {
        $author = new \StdClass;
        $author->name = $this->data['includes']['users'][0]['name'];
        $author->username = $this->data['includes']['users'][0]['username'];
        $author->profile_image_url = $this->data['includes']['users'][0]['profile_image_url'];

        return $author;
    }

    public function getDetailsAttribute()
    {
        $tweetDetails = new \StdClass;
        $tweetDetails->description = $this->data['data']['text'];

        return $tweetDetails;
    }

    public function getDescriptionAttribute()
    {
        return $this->data['data']['text'];
    }

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
