<?php

namespace App\Jobs;

use App\Models\Analytic;
use App\Models\Media;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\Subscriber;
use App\Models\Tender;
use App\Models\User;
use Carbon\Carbon;
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
        $order = new Order();
        $days = [];

        // get the days in names like Monday,Tuesday and so on...
        for ($i = 0; $i < 7; $i++) {
            $days[] = Carbon::now()->subDays($i)->format('d');
        }

        $orders = $order->newQuery()
            ->select('updated_at')
            ->whereDate('updated_at', '>=', today()->subDays(6)->format('Y-m-d'))
            ->whereDate('updated_at', '<=', today()->format('Y-m-d'))
            ->get()
            ->groupBy(static fn($val) => Carbon::parse($val->updated_at)->format('d'));

        // Analytics
        $analytics = Analytic::query()->first();
        $analytics->update([
            'data' => [
                'users' => count(User::query()->get()),
                'orders' => count($order->newQuery()->get()),
                'pendingOrders' => count($order->newQuery()->where('isClosed', true)->get()),
                'tenders' => count(Tender::query()->get()),
                'pendingTenders' => count(Tender::query()->where('isClosed', true)->get()),
                'leads' => count(Subscriber::query()->where('isLead', true)->get()),
                'contacts' => count(Subscriber::query()->where('isContact', true)->get()),
                'customers' => count(Subscriber::query()->where('isCustomer', true)->get()),
                'failed' => count(Subscriber::query()->where('isClosed', true)->get()),
                'products' => count(Product::query()->get()),
                'blogViews' => Post::query()->sum('views'),
                'blogLikes' => Post::query()->sum('likes'),
                'blogs' => count(Post::query()->get()),
                'media' => count(Arr::flatten(Media::query()->select('pathNames')->get()->toArray())),
                'mediaSize' => array_sum(Arr::flatten(Media::query()->select('sizes')->get()->toArray())),
                'orderSummary' => [
                    isset($orders[$days[6]]) ? count($orders[$days[6]]) : 0,
                    isset($orders[$days[5]]) ? count($orders[$days[5]]) : 0,
                    isset($orders[$days[4]]) ? count($orders[$days[4]]) : 0,
                    isset($orders[$days[3]]) ? count($orders[$days[3]]) : 0,
                    isset($orders[$days[2]]) ? count($orders[$days[2]]) : 0,
                    isset($orders[$days[1]]) ? count($orders[$days[1]]) : 0,
                    isset($orders[$days[0]]) ? count($orders[$days[0]]) : 0
                ]
            ]
        ]);
    }
}
