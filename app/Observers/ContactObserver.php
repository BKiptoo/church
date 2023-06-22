<?php

namespace App\Observers;

use App\Jobs\MailJob;
use App\Models\Contact;

class ContactObserver
{
    /**
     * Handle the Contact "created" event.
     *
     * @param Contact $contact
     * @return void
     */
    public function created(Contact $contact)
    {
        dispatch(new MailJob(
            $contact->firstName . ' ' . $contact->lastName,
            $contact->email,
            'Enquiry On ' . $contact->subject,
            'We have received your enquiry. Our team will reach you.'
        ))->onQueue('emails')->delay(now()->addSeconds(30));
    }

    /**
     * Handle the Contact "updated" event.
     *
     * @param Contact $contact
     * @return void
     */
    public function updated(Contact $contact)
    {
        //
    }

    /**
     * Handle the Contact "deleted" event.
     *
     * @param Contact $contact
     * @return void
     */
    public function deleted(Contact $contact)
    {
        //
    }

    /**
     * Handle the Contact "restored" event.
     *
     * @param Contact $contact
     * @return void
     */
    public function restored(Contact $contact)
    {
        //
    }

    /**
     * Handle the Contact "force deleted" event.
     *
     * @param Contact $contact
     * @return void
     */
    public function forceDeleted(Contact $contact)
    {
        //
    }
}
