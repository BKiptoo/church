<?php

namespace App\Observers;

use App\Jobs\SyncAnalyticDataJob;
use App\Models\Post;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     *
     * @param Post $post
     * @return void
     */
    public function created(Post $post)
    {
        dispatch(new SyncAnalyticDataJob())->onQueue('default')->delay(now()->addMinute());
    }

    /**
     * Handle the Post "updated" event.
     *
     * @param Post $post
     * @return void
     */
    public function updated(Post $post)
    {
        dispatch(new SyncAnalyticDataJob())->onQueue('default')->delay(now()->addMinute());
    }

    /**
     * Handle the Post "deleted" event.
     *
     * @param Post $post
     * @return void
     */
    public function deleted(Post $post)
    {
        dispatch(new SyncAnalyticDataJob())->onQueue('default')->delay(now()->addMinute());
    }

    /**
     * Handle the Post "restored" event.
     *
     * @param Post $post
     * @return void
     */
    public function restored(Post $post)
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     *
     * @param Post $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        dispatch(new SyncAnalyticDataJob())->onQueue('default')->delay(now()->addMinute());
    }
}
