<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IssueStateChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    private $payload;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->payload->to)
            ->subject($this->payload->subject)
            ->replyTo($this->payload->reply_to)
            ->markdown('mails.issue-state-changed', [
                'name' => $this->payload->name,
                'message' => $this->payload->message,
                'message2' => $this->payload->message2,
            ]);
    }
}
