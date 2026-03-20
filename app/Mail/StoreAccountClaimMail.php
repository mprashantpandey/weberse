<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StoreAccountClaimMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly User $user,
        public readonly string $claimUrl,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Set your Weberse account password',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.store.account-claim',
            with: [
                'claimUrl' => $this->claimUrl,
            ],
        );
    }
}

