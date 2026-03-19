<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Services\HRM\ApprovalNotificationService;
use App\Services\Settings\SiteSettingsService;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('system:heartbeat', function (SiteSettingsService $settings) {
    $settings->putSystemHealth([
        'scheduler_last_ran_at' => now()->toIso8601String(),
    ]);

    $this->info('System heartbeat recorded.');
})->purpose('Record the scheduler heartbeat for system health monitoring');

Artisan::command('hrm:send-pending-approvals-digest', function (ApprovalNotificationService $notifications) {
    $sent = $notifications->sendDailyPendingDigest();

    $this->info("Pending approvals digest sent to {$sent} recipient(s).");
})->purpose('Send the daily HR pending approvals email digest');

Artisan::command('system:process-queue', function (SiteSettingsService $settings) {
    $settings->putSystemHealth([
        'queue_last_started_at' => now()->toIso8601String(),
    ]);

    $this->call('queue:work', [
        '--stop-when-empty' => true,
        '--tries' => 3,
        '--queue' => 'default',
    ]);

    $settings->putSystemHealth([
        'queue_last_finished_at' => now()->toIso8601String(),
    ]);

    $this->info('Queue processed.');
})->purpose('Process queued jobs through the scheduler-safe queue worker');

Schedule::command('system:heartbeat')->everyMinute()->withoutOverlapping();
Schedule::command('hrm:send-pending-approvals-digest')->weekdays()->dailyAt('09:00');
Schedule::command('system:process-queue')->everyMinute()->withoutOverlapping();
