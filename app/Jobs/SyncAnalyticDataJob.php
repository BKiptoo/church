<?php

namespace App\Jobs;

use App\Models\Analytic;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\ThrottlesExceptions;
use Illuminate\Queue\SerializesModels;

class SyncAnalyticDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * The unique ID of the job.
     *
     * @return string
     */
    public function uniqueId(): string
    {
        return 'manager';
    }

    /**
     * set a middleware to prevent job overlapping
     *
     * @return array
     */
    public function middleware(): array
    {
        return [
            (new ThrottlesExceptions(5, 5))->backoff(5)
        ];
    }

    /**
     * Determine the time at which the job should timeout.
     *
     * @return DateTime
     */
    public function retryUntil(): DateTime
    {
        return now()->addMinutes(5);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        // Analytics
    }
}
