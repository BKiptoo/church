<?php

namespace App\Observers;

use App\Jobs\MailJob;
use App\Models\JobApplication;

class JobApplicationObserver
{
    /**
     * Handle the JobApplication "created" event.
     *
     * @param JobApplication $jobApplication
     * @return void
     */
    public function created(JobApplication $jobApplication)
    {
        // Send an email of acknowledgement
        dispatch(new MailJob(
            $jobApplication->lastName . ' ' . $jobApplication->firstName,
            $jobApplication->email,
            $jobApplication->career->name . ' Application',
            'We have received your application, we will reach out after our review.'
        ))->onQueue('emails')
            ->delay(now()->addSeconds(30));
    }

    /**
     * Handle the JobApplication "updated" event.
     *
     * @param JobApplication $jobApplication
     * @return void
     */
    public function updated(JobApplication $jobApplication)
    {
        //
    }

    /**
     * Handle the JobApplication "deleted" event.
     *
     * @param JobApplication $jobApplication
     * @return void
     */
    public function deleted(JobApplication $jobApplication)
    {
        //
    }

    /**
     * Handle the JobApplication "restored" event.
     *
     * @param JobApplication $jobApplication
     * @return void
     */
    public function restored(JobApplication $jobApplication)
    {
        //
    }

    /**
     * Handle the JobApplication "force deleted" event.
     *
     * @param JobApplication $jobApplication
     * @return void
     */
    public function forceDeleted(JobApplication $jobApplication)
    {
        //
    }
}
