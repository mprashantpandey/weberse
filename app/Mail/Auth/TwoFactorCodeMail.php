<?php

namespace App\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TwoFactorCodeMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly string $name,
        public readonly string $code
    ) {}

    public function build(): self
    {
        return $this->subject('Your Weberse verification code')
            ->view('emails.auth.two-factor-code');
    }
}
