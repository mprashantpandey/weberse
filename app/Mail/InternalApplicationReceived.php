<?php

namespace App\Mail;

use App\Models\HRM\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InternalApplicationReceived extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly JobApplication $application,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New job application: '.$this->application->name.' for '.$this->application->jobOpening?->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.hr.internal-application-received',
        );
    }
}
