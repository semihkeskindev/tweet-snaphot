<?php

namespace App\Jobs;

use App\Models\TweetRequestLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LogTweetRequestJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private int $tweetId;
    private array $result;
    private int $statusCode;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $tweetId, array $result, int $statusCode)
    {
        $this->tweetId = $tweetId;
        $this->result = $result;
        $this->statusCode = $statusCode;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $log = new TweetRequestLog();
        $log->tweet_id = $this->tweetId;
        $log->response = $this->result;
        $log->status_code = $this->statusCode;
        $log->save();
    }
}
