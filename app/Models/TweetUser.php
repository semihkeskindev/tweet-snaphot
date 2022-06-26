<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;

class TweetUser extends Model
{
    use HasFactory;
    use AsPivot;

    protected $guarded = [];


}
