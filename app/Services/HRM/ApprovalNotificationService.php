<?php

namespace App\Services\HRM;

use App\Models\HRM\CompensationRecord;
use App\Models\HRM\EmployeePerk;
use App\Models\HRM\ExpenseClaim;
use App\Models\HRM\LeaveRequest;
use App\Models\User;
use App\Services\Communication\EmailCenterService;
use App\Services\Mail\PlatformMailConfigurator;
use App\Services\Settings\SiteSettingsService;

class ApprovalNotificationService
{
    public function __construct(
        private readonly SiteSettingsService $settings,
        private readonly PlatformMailConfigurator $mailConfigurator,
        private readonly EmailCenterService $emailCenter,
    ) {
    }

    public function sendLeaveStatusUpdate(LeaveRequest $leave, ?User $actor = null): bool
    {
        $employee = $leave->employeeProfile?->user;

        if (! $employee?->email || ! $this->shouldNotifyEmployee($leave->status)) {
            return false;
        }

        return $this->sendEmployeeStatusUpdate(
            employee: $employee,
            itemType: 'Leave Request',
            itemTitle: str($leave->type)->replace('_', ' ')->title().' • '.$leave->start_date?->format('d M Y').' to '.$leave->end_date?->format('d M Y'),
            status: $leave->status,
            reviewNote: $leave->review_note,
            actor: $actor,
            metaType: 'hr_leave_status_update',
        );
    }

    public function sendExpenseStatusUpdate(ExpenseClaim $claim, ?User $actor = null): bool
    {
        $employee = $claim->employeeProfile?->user;

        if (! $employee?->email || ! $this->shouldNotifyEmployee($claim->status)) {
            return false;
        }

        return $this->sendEmployeeStatusUpdate(
            employee: $employee,
            itemType: 'Expense Claim',
            itemTitle: $claim->title.' • '.$claim->currency.' '.number_format((float) $claim->amount, 2),
            status: $claim->status,
            reviewNote: $claim->review_note,
            actor: $actor,
            metaType: 'hr_expense_status_update',
        );
    }

    public function sendCompensationStatusUpdate(CompensationRecord $record, ?User $actor = null): bool
    {
        $employee = $record->employeeProfile?->user;

        if (! $employee?->email || ! $this->shouldNotifyEmployee($record->status)) {
            return false;
        }

        return $this->sendEmployeeStatusUpdate(
            employee: $employee,
            itemType: 'Compensation Update',
            itemTitle: $record->title.' • '.$record->currency.' '.number_format((float) $record->amount, 2),
            status: $record->status,
            reviewNote: $record->review_note,
            actor: $actor,
            metaType: 'hr_compensation_status_update',
        );
    }

    public function sendPerkStatusUpdate(EmployeePerk $perk, ?User $actor = null): bool
    {
        $employee = $perk->employeeProfile?->user;

        if (! $employee?->email || ! $this->shouldNotifyEmployee($perk->status)) {
            return false;
        }

        return $this->sendEmployeeStatusUpdate(
            employee: $employee,
            itemType: 'Perk Update',
            itemTitle: $perk->title.($perk->value ? ' • '.$perk->value : ''),
            status: $perk->status,
            reviewNote: $perk->review_note,
            actor: $actor,
            metaType: 'hr_perk_status_update',
        );
    }

    public function sendDailyPendingDigest(?User $sender = null): int
    {
        $pendingLeaves = LeaveRequest::query()->where('status', 'pending')->count();
        $pendingExpenses = ExpenseClaim::query()->where('status', 'pending')->count();
        $pendingCompensation = CompensationRecord::query()->where('status', 'pending_approval')->count();
        $pendingPerks = EmployeePerk::query()->where('status', 'pending_approval')->count();

        $total = $pendingLeaves + $pendingExpenses + $pendingCompensation + $pendingPerks;

        if ($total === 0 || ! $this->mailConfigurator->apply('hr')) {
            return 0;
        }

        $recipients = $this->internalRecipients();

        if ($recipients === []) {
            return 0;
        }

        $summaryLines = [
            "Leave requests: {$pendingLeaves}",
            "Expense claims: {$pendingExpenses}",
            "Compensation changes: {$pendingCompensation}",
            "Perk changes: {$pendingPerks}",
            '',
            'Open the HR approvals queue to review them.',
        ];

        $sent = 0;

        foreach ($recipients as $recipient) {
            $ok = $this->emailCenter->sendTemplate(
                slug: 'hr-daily-approvals-summary',
                recipientEmail: $recipient,
                recipientName: null,
                variables: [
                    'date' => now()->format('d M Y'),
                    'total_pending' => (string) $total,
                    'pending_summary' => implode("\n", $summaryLines),
                ],
                sender: $sender,
                meta: ['type' => 'hr_daily_pending_approvals'],
                scope: 'hr',
            );

            if ($ok) {
                $sent++;
            }
        }

        return $sent;
    }

    private function sendEmployeeStatusUpdate(
        User $employee,
        string $itemType,
        string $itemTitle,
        string $status,
        ?string $reviewNote,
        ?User $actor,
        string $metaType,
    ): bool {
        if (! $this->mailConfigurator->apply('hr')) {
            return false;
        }

        return $this->emailCenter->sendTemplate(
            slug: 'employee-approval-status-update',
            recipientEmail: $employee->email,
            recipientName: $employee->name,
            variables: [
                'name' => $employee->name,
                'item_type' => $itemType,
                'item_title' => $itemTitle,
                'status' => str($status)->replace('_', ' ')->title(),
                'review_note' => $reviewNote ?: 'No additional note was shared.',
                'reviewed_by' => $actor?->name ?: 'HR Team',
            ],
            sender: $actor,
            meta: ['type' => $metaType],
            scope: 'hr',
        );
    }

    private function shouldNotifyEmployee(string $status): bool
    {
        return in_array($status, ['approved', 'rejected', 'reimbursed', 'active'], true);
    }

    /**
     * @return list<string>
     */
    private function internalRecipients(): array
    {
        $mailSettings = $this->settings->getHrMailSettings();

        return collect([
            $mailSettings['hr_recruitment_email'] ?? null,
            $mailSettings['admin_alert_email'] ?? null,
        ])
            ->merge(
                User::query()
                    ->role(['admin', 'hr'])
                    ->whereNotNull('email')
                    ->pluck('email')
            )
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
