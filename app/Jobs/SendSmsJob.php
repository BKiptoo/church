<?php

namespace App\Jobs;

use App\Http\Controllers\SystemController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SMSALES\API\Trigger;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private readonly string $phoneNumber,
        private readonly string $message
    )
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        /**
         * initiate bulk sms
         * @return mixed
         */
        $response = (new Trigger())->send([
            "api_sender" => "shiftech",// required check on your senderID's list for the API Sender
            "message" => $this->message,// required
            "phone_numbers" => [$this->phoneNumber],// required
        ]);

        SystemController::log([$response], 'success', 'sms');
    }
}
