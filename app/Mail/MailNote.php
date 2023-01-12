<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailNote extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        private readonly string      $name,
        private readonly string      $email,
        private readonly string      $title,
        private readonly string      $body,
        private readonly bool|null   $showButton = null,
        private readonly string|null $url = null,
        private readonly string|null $buttonName = null
    )
    {
        $showButton ??= false;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), $this->name)
            ->view('emails.mail', [
                'name' => $this->name,
                'subject' => $this->title,
                'email' => $this->email,
                'body' => $this->body,
                'showButton' => $this->showButton,
                'url' => $this->url,
                'buttonName' => $this->buttonName,
                'title' => $this->title,
            ]);
    }
}
