<?php

namespace App\Observers;

use App\Jobs\MailJob;
use App\Jobs\SyncAnalyticDataJob;
use App\Models\Order;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param Order $order
     * @return void
     */
    public function created(Order $order)
    {
        dispatch(new MailJob(
            $order->email,
            $order->email,
            'Order For Product ' . $order->product->name,
            'Your order ' . $order->orderNumber . ' has been received. Our team will reach you for more enquiry.'
        ))->onQueue('emails')->delay(now()->addSeconds(30));

        dispatch(new SyncAnalyticDataJob())->onQueue('default')->delay(now()->addMinute());
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param Order $order
     * @return void
     */
    public function updated(Order $order)
    {
        dispatch(new SyncAnalyticDataJob())->onQueue('default')->delay(now()->addMinute());
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param Order $order
     * @return void
     */
    public function deleted(Order $order)
    {
        dispatch(new SyncAnalyticDataJob())->onQueue('default')->delay(now()->addMinute());
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param Order $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param Order $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        dispatch(new SyncAnalyticDataJob())->onQueue('default')->delay(now()->addMinute());
    }
}
