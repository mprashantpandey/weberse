<?php

namespace App\Jobs;

use App\Mail\DynamicHtmlMail;
use App\Models\Communication\OutboundEmail;
use App\Services\Mail\PlatformMailConfigurator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendPlatformEmailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public function __construct(
        public readonly int $outboundEmailId,
        public readonly string $scope = 'general',
    ) {
    }

    public function handle(PlatformMailConfigurator $mailConfigurator): void
    {
        $log = OutboundEmail::query()->find($this->outboundEmailId);

        if (! $log || $log->status === 'sent') {
            return;
        }

        try {
            if (! $mailConfigurator->apply($this->scope)) {
                $log->update([
                    'status' => 'failed',
                    'error_message' => $this->scope === 'hr'
                        ? 'HR email settings are incomplete.'
                        : 'General email settings are incomplete.',
                ]);

                return;
            }

            Mail::to($log->recipient_email, $log->recipient_name)->send(
                new DynamicHtmlMail($log->subject, nl2br($log->body))
            );

            $log->update([
                'status' => 'sent',
                'sent_at' => now(),
                'error_message' => null,
            ]);
        } catch (Throwable $exception) {
            $log->update([
                'status' => 'failed',
                'error_message' => $exception->getMessage(),
            ]);

            Log::warning('Queued email delivery failed.', [
                'outbound_email_id' => $log->id,
                'recipient' => $log->recipient_email,
                'message' => $exception->getMessage(),
            ]);

            throw $exception;
        }
    }
}
