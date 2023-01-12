<?php

namespace App\Jobs;

use App\Mail\MailNote;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param string $name
     * @param string $email
     * @param string $subject
     * @param string $body
     * @param bool $showButton
     * @param string|null $url
     * @param string|null $buttonName
     */
    public function __construct(
        private readonly string      $name,
        private readonly string      $email,
        private readonly string      $subject,
        private readonly string      $body,
        private readonly bool|null   $showButton = null,
        private readonly string|null $url = null,
        private readonly string|null $buttonName = null
    )
    {
        $showButton ??= false;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
            // send an email here
            Mail::to($this->email)->send(new MailNote(
                $this->name,
                $this->email,
                $this->subject,
                $this->body,
                $this->showButton,
                $this->url,
                $this->buttonName
            ));
        } catch (Exception $exception) {
            Log::info('Mail failed to send to ' . $this->email);
            Log::error($exception->getMessage());
        }
    }
}
