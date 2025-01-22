<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        protected string $userPhone,
        protected string $message
    )
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Заявка от пользователя',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.send-contact',
            with: [
                'phone' => $this->userPhone,
                'message' => $this->message
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
