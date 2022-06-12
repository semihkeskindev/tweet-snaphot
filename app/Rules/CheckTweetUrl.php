<?php

namespace App\Rules;

use App\Services\TwitterService;
use Illuminate\Contracts\Validation\Rule;

class CheckTweetUrl implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (bool) app(TwitterService::class)->getTweetIdFromTweetUrl($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Girdiğiniz tweet adresi yanlış, lütfen kontrol ediniz.';
    }
}
