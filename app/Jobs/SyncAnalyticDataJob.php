<?php

namespace App\Jobs;

use App\Models\Analytic;
use App\Models\Media;
use App\Models\Order;
use App\Models\Product;
use App\Models\Subscriber;
use App\Models\Tender;
use App\Models\User;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\ThrottlesExceptions;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

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
        $analytics = Analytic::query()->first();
        $analytics->update([
            'data' => [
                'users' => count(User::query()->get()),
                'orders' => count(Order::query()->get()),
                'openOrders' => count(Order::query()->where('isClosed', true)->get()),
                'tenders' => count(Tender::query()->get()),
                'openTenders' => count(Tender::query()->where('isClosed', true)->get()),
                'leads' => count(Subscriber::query()->where('isLead', true)->get()),
                'contacts' => count(Subscriber::query()->where('isContact', true)->get()),
                'customers' => count(Subscriber::query()->where('isCustomer', true)->get()),
                'products' => count(Product::query()->get()),
                'media' => array_sum(Arr::flatten(Media::query()->select('sizes')->get()->toArray()))
            ]
        ]);
    }
}
