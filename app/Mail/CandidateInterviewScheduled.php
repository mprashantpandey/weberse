<?php

namespace App\Mail;

use App\Models\HRM\InterviewSchedule;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CandidateInterviewScheduled extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly InterviewSchedule $interview,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Interview scheduled for '.$this->interview->application?->jobOpening?->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.hr.candidate-interview-scheduled',
        );
    }
}
