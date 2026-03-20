<?php

namespace App\Services\Mail;

use App\Services\Settings\SiteSettingsService;
use Illuminate\Mail\MailManager;

class PlatformMailConfigurator
{
    public function __construct(
        private readonly SiteSettingsService $settings,
        private readonly MailManager $mailManager,
    ) {
    }

    public function apply(string $scope = 'general'): bool
    {
        $mail = $scope === 'hr'
            ? $this->settings->getHrMailSettings()
            : $this->settings->getGeneralMailSettings();

        if (
            empty($mail['host']) ||
            empty($mail['port']) ||
            empty($mail['username']) ||
            empty($mail['password']) ||
            empty($mail['from_address'])
        ) {
            return false;
        }

        config([
            'mail.default' => 'platform_dynamic',
            'mail.mailers.platform_dynamic' => [
                'transport' => 'smtp',
                'host' => $mail['host'],
                'port' => (int) $mail['port'],
                'encryption' => $mail['encryption'] ?: null,
                'username' => $mail['username'],
                'password' => $mail['password'],
                'timeout' => null,
                'local_domain' => env('MAIL_EHLO_DOMAIN'),
            ],
            'mail.from' => [
                'address' => $mail['from_address'],
                'name' => $mail['from_name'] ?: 'Weberse Infotech',
            ],
        ]);

        $this->mailManager->purge('platform_dynamic');

        return true;
    }

    public function mailer(string $scope = 'general'): ?string
    {
        return $this->apply($scope) ? 'platform_dynamic' : null;
    }
}
