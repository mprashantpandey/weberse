<?php

namespace App\Services\Communication;

use App\Mail\DynamicHtmlMail;
use App\Models\Communication\EmailTemplate;
use App\Models\Communication\NewsletterCampaign;
use App\Models\Communication\NewsletterSubscriber;
use App\Models\Communication\OutboundEmail;
use App\Models\User;
use App\Services\Mail\PlatformMailConfigurator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class EmailCenterService
{
    public function __construct(
        private readonly PlatformMailConfigurator $mailConfigurator,
    ) {
    }

    public function render(string $content, array $variables = []): string
    {
        return preg_replace_callback('/\{\{\s*([a-zA-Z0-9_]+)\s*\}\}/', function (array $matches) use ($variables) {
            $key = $matches[1];

            return e((string) ($variables[$key] ?? ''));
        }, $content) ?? $content;
    }

    public function sendDirect(
        string $recipientEmail,
        ?string $recipientName,
        string $subject,
        string $body,
        ?User $sender = null,
        ?EmailTemplate $template = null,
        ?NewsletterCampaign $campaign = null,
        array $meta = [],
        string $scope = 'general',
    ): bool {
        $log = OutboundEmail::query()->create([
            'email_template_id' => $template?->id,
            'newsletter_campaign_id' => $campaign?->id,
            'user_id' => $sender?->id,
            'recipient_name' => $recipientName,
            'recipient_email' => $recipientEmail,
            'subject' => $subject,
            'body' => $body,
            'status' => 'pending',
            'meta' => $meta ?: null,
        ]);

        try {
            if (! $this->mailConfigurator->apply($scope)) {
                $log->update([
                    'status' => 'failed',
                    'error_message' => $scope === 'hr'
                        ? 'HR email settings are incomplete.'
                        : 'General email settings are incomplete.',
                ]);

                return false;
            }

            Mail::to($recipientEmail, $recipientName)->send(new DynamicHtmlMail($subject, nl2br($body)));

            $log->update([
                'status' => 'sent',
                'sent_at' => now(),
            ]);

            return true;
        } catch (Throwable $exception) {
            $log->update([
                'status' => 'failed',
                'error_message' => $exception->getMessage(),
            ]);

            Log::warning('Email delivery failed.', [
                'recipient' => $recipientEmail,
                'message' => $exception->getMessage(),
            ]);

            return false;
        }
    }

    public function sendTemplate(
        string $slug,
        string $recipientEmail,
        ?string $recipientName,
        array $variables = [],
        ?User $sender = null,
        array $meta = [],
        string $scope = 'general',
    ): bool {
        $template = EmailTemplate::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (! $template) {
            return false;
        }

        return $this->sendDirect(
            recipientEmail: $recipientEmail,
            recipientName: $recipientName,
            subject: $this->render($template->subject, $variables),
            body: $this->render($template->body, $variables),
            sender: $sender,
            template: $template,
            meta: $meta,
            scope: $scope,
        );
    }

    public function sendCampaign(NewsletterCampaign $campaign, ?User $sender = null): int
    {
        $subscribers = NewsletterSubscriber::query()
            ->where('status', 'active')
            ->orderBy('email')
            ->get();

        $sent = 0;

        foreach ($subscribers as $subscriber) {
            $ok = $this->sendDirect(
                recipientEmail: $subscriber->email,
                recipientName: $subscriber->name,
                subject: $campaign->subject,
                body: $this->render($campaign->body, [
                    'name' => $subscriber->name ?: 'Subscriber',
                    'email' => $subscriber->email,
                ]),
                sender: $sender,
                template: $campaign->template,
                campaign: $campaign,
                meta: ['type' => 'newsletter_campaign'],
                scope: 'general',
            );

            if ($ok) {
                $sent++;
                $subscriber->update([
                    'last_sent_at' => now(),
                ]);
            }
        }

        $campaign->update([
            'status' => 'sent',
            'sent_at' => now(),
            'sent_count' => $sent,
        ]);

        return $sent;
    }
}
