<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CandidateInterviewScheduled;
use App\Mail\InternalInterviewScheduled;
use App\Services\Communication\EmailCenterService;
use App\Models\HRM\AttendanceRecord;
use App\Models\HRM\CompensationRecord;
use App\Models\HRM\Department;
use App\Models\HRM\EmployeeProfile;
use App\Models\HRM\EmployeePerk;
use App\Models\HRM\ExpenseClaim;
use App\Models\HRM\InterviewSchedule;
use App\Models\HRM\JobApplication;
use App\Models\HRM\JobOpening;
use App\Models\HRM\LeaveRequest;
use App\Services\HRM\ApprovalNotificationService;
use App\Services\Mail\PlatformMailConfigurator;
use App\Services\Settings\SiteSettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HrmController extends Controller
{
    public function index(): View
    {
        return view('admin.hrm.index', [
            'jobs' => JobOpening::query()->with('department')->latest()->take(5)->get(),
            'applications' => JobApplication::query()->with('jobOpening')->latest()->take(8)->get(),
            'employees' => EmployeeProfile::query()->with(['user', 'department'])->latest()->take(8)->get(),
            'interviews' => InterviewSchedule::query()->with('application.jobOpening')->latest('scheduled_for')->take(6)->get(),
            'summary' => [
                'open_roles' => JobOpening::query()->where('is_published', true)->count(),
                'applications' => JobApplication::query()->count(),
                'screening' => JobApplication::query()->where('status', 'screening')->count(),
                'employees' => EmployeeProfile::query()->count(),
                'pending_leaves' => LeaveRequest::query()->where('status', 'pending')->count(),
                'pending_expenses' => ExpenseClaim::query()->where('status', 'pending')->count(),
                'pending_compensation' => CompensationRecord::query()->where('status', 'pending_approval')->count(),
                'pending_perks' => EmployeePerk::query()->where('status', 'pending_approval')->count(),
                'today_attendance' => AttendanceRecord::query()->whereDate('work_date', today())->count(),
            ],
        ]);
    }

    public function approvals(): View
    {
        return view('admin.hrm.approvals', [
            'pendingLeaves' => LeaveRequest::query()
                ->with(['employeeProfile.user', 'employeeProfile.department'])
                ->where('status', 'pending')
                ->latest('start_date')
                ->get(),
            'pendingExpenses' => ExpenseClaim::query()
                ->with(['employeeProfile.user'])
                ->where('status', 'pending')
                ->latest('expense_date')
                ->get(),
            'pendingCompensation' => CompensationRecord::query()
                ->with(['employeeProfile.user', 'creator'])
                ->where('status', 'pending_approval')
                ->latest('effective_from')
                ->get(),
            'pendingPerks' => EmployeePerk::query()
                ->with(['employeeProfile.user', 'creator'])
                ->where('status', 'pending_approval')
                ->latest()
                ->get(),
        ]);
    }

    public function leaves(): View
    {
        return view('admin.hrm.leaves', [
            'leaves' => LeaveRequest::query()
                ->with(['employeeProfile.user', 'employeeProfile.department', 'reviewer'])
                ->latest('start_date')
                ->get(),
        ]);
    }

    public function attendance(): View
    {
        return view('admin.hrm.attendance', [
            'records' => AttendanceRecord::query()
                ->with(['employeeProfile.user', 'employeeProfile.department', 'marker'])
                ->latest('work_date')
                ->get(),
            'employees' => EmployeeProfile::query()->with('user')->orderBy('employee_code')->get(),
        ]);
    }

    public function jobs(): View
    {
        return view('admin.hrm.jobs', [
            'jobs' => JobOpening::query()->with('department')->latest()->get(),
        ]);
    }

    public function applications(): View
    {
        return view('admin.hrm.applications', [
            'applications' => JobApplication::query()->with(['jobOpening.department', 'interviews'])->latest()->get(),
        ]);
    }

    public function employees(): View
    {
        return view('admin.hrm.employees', [
            'employees' => EmployeeProfile::query()
                ->with(['user', 'department', 'compensationRecords', 'expenseClaims', 'perks'])
                ->latest()
                ->get(),
        ]);
    }

    public function interviews(): View
    {
        return view('admin.hrm.interviews', [
            'interviews' => InterviewSchedule::query()
                ->with(['application.jobOpening', 'application', 'scheduler'])
                ->latest('scheduled_for')
                ->get(),
            'applications' => JobApplication::query()
                ->with('jobOpening')
                ->latest()
                ->get(),
        ]);
    }

    public function compensation(): View
    {
        return view('admin.hrm.compensation', [
            'records' => CompensationRecord::query()
                ->with(['employeeProfile.user', 'creator', 'approver'])
                ->latest('effective_from')
                ->get(),
            'employees' => EmployeeProfile::query()->with('user')->orderBy('employee_code')->get(),
        ]);
    }

    public function expenses(): View
    {
        return view('admin.hrm.expenses', [
            'claims' => ExpenseClaim::query()
                ->with(['employeeProfile.user', 'approver'])
                ->latest('expense_date')
                ->get(),
            'employees' => EmployeeProfile::query()->with('user')->orderBy('employee_code')->get(),
        ]);
    }

    public function perks(): View
    {
        return view('admin.hrm.perks', [
            'perks' => EmployeePerk::query()
                ->with(['employeeProfile.user', 'creator', 'approver'])
                ->latest()
                ->get(),
            'employees' => EmployeeProfile::query()->with('user')->orderBy('employee_code')->get(),
        ]);
    }

    public function createJob(): View
    {
        return view('admin.hrm.job-form', [
            'job' => new JobOpening([
                'employment_type' => 'full_time',
                'salary_currency' => 'INR',
                'is_published' => true,
            ]),
            'departments' => Department::query()->orderBy('name')->get(),
            'mode' => 'create',
        ]);
    }

    public function editJob(JobOpening $jobOpening): View
    {
        return view('admin.hrm.job-form', [
            'job' => $jobOpening->load('department'),
            'departments' => Department::query()->orderBy('name')->get(),
            'mode' => 'edit',
        ]);
    }

    public function showApplication(JobApplication $application): View
    {
        return view('admin.hrm.application-show', [
            'application' => $application->load(['jobOpening.department', 'interviews.scheduler']),
        ]);
    }

    public function storeJob(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'department_id' => ['nullable', 'exists:departments,id'],
            'title' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'employment_type' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'salary_min' => ['nullable', 'integer', 'min:0'],
            'salary_max' => ['nullable', 'integer', 'min:0'],
            'salary_currency' => ['nullable', 'string', 'max:10'],
            'experience_min' => ['nullable', 'integer', 'min:0', 'max:60'],
            'experience_max' => ['nullable', 'integer', 'min:0', 'max:60'],
            'notice_period' => ['nullable', 'string', 'max:100'],
            'immediate_joiner_preferred' => ['nullable'],
            'skills' => ['nullable', 'string'],
            'application_questions' => ['nullable', 'string'],
            'is_published' => ['nullable'],
        ]);

        JobOpening::query()->create($this->mapJobData($data));

        return back()->with('status', 'Job opening created.');
    }

    public function updateJob(Request $request, JobOpening $jobOpening): RedirectResponse
    {
        $data = $request->validate([
            'department_id' => ['nullable', 'exists:departments,id'],
            'title' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'employment_type' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'salary_min' => ['nullable', 'integer', 'min:0'],
            'salary_max' => ['nullable', 'integer', 'min:0'],
            'salary_currency' => ['nullable', 'string', 'max:10'],
            'experience_min' => ['nullable', 'integer', 'min:0', 'max:60'],
            'experience_max' => ['nullable', 'integer', 'min:0', 'max:60'],
            'notice_period' => ['nullable', 'string', 'max:100'],
            'immediate_joiner_preferred' => ['nullable'],
            'skills' => ['nullable', 'string'],
            'application_questions' => ['nullable', 'string'],
            'is_published' => ['nullable'],
        ]);

        $jobOpening->update($this->mapJobData($data, $jobOpening));

        return back()->with('status', 'Job opening updated.');
    }

    public function updateApplication(Request $request, JobApplication $application): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'string', 'max:50'],
            'interview_status' => ['required', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
        ]);

        $application->update($data);

        return back()->with('status', 'Application updated.');
    }

    public function updateLeave(Request $request, LeaveRequest $leave, ApprovalNotificationService $notifications): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'string', 'max:50'],
            'reason' => ['nullable', 'string'],
            'review_note' => ['nullable', 'string'],
        ]);

        $leave->update([
            'status' => $data['status'],
            'reason' => $data['reason'] ?? $leave->reason,
            'review_note' => $data['review_note'] ?? null,
            'reviewed_by' => in_array($data['status'], ['approved', 'rejected'], true) ? $request->user()?->id : null,
            'reviewed_at' => in_array($data['status'], ['approved', 'rejected'], true) ? now() : null,
        ]);

        $notifications->sendLeaveStatusUpdate($leave->fresh(['employeeProfile.user']), $request->user());

        return back()->with('status', 'Leave request updated.');
    }

    public function storeAttendance(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'employee_profile_id' => ['required', 'exists:employee_profiles,id'],
            'work_date' => ['required', 'date'],
            'clock_in_at' => ['nullable', 'date'],
            'clock_out_at' => ['nullable', 'date', 'after_or_equal:clock_in_at'],
            'status' => ['required', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
        ]);

        AttendanceRecord::query()->updateOrCreate(
            [
                'employee_profile_id' => $data['employee_profile_id'],
                'work_date' => $data['work_date'],
            ],
            [
                'marked_by' => $request->user()?->id,
                'clock_in_at' => $data['clock_in_at'] ?? null,
                'clock_out_at' => $data['clock_out_at'] ?? null,
                'status' => $data['status'],
                'notes' => $data['notes'] ?? null,
            ]
        );

        return back()->with('status', 'Attendance record saved.');
    }

    public function updateAttendance(Request $request, AttendanceRecord $attendance): RedirectResponse
    {
        $data = $request->validate([
            'clock_in_at' => ['nullable', 'date'],
            'clock_out_at' => ['nullable', 'date', 'after_or_equal:clock_in_at'],
            'status' => ['required', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
        ]);

        $attendance->update([
            ...$data,
            'marked_by' => $request->user()?->id,
        ]);

        return back()->with('status', 'Attendance updated.');
    }

    public function storeInterview(
        Request $request,
        SiteSettingsService $settings,
        PlatformMailConfigurator $mailConfigurator,
        EmailCenterService $emailCenter,
    ): RedirectResponse {
        $data = $request->validate([
            'job_application_id' => ['required', 'exists:job_applications,id'],
            'interviewer_name' => ['required', 'string', 'max:255'],
            'interviewer_email' => ['nullable', 'email'],
            'mode' => ['required', 'string', 'max:50'],
            'meeting_link' => ['nullable', 'url', 'max:1000'],
            'scheduled_for' => ['required', 'date'],
            'duration_minutes' => ['required', 'integer', 'min:15', 'max:240'],
            'stage' => ['required', 'string', 'max:50'],
            'status' => ['required', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
        ]);

        $interview = InterviewSchedule::query()->create([
            ...$data,
            'scheduled_by' => $request->user()?->id,
        ]);

        $interview->application()->update([
            'interview_status' => $data['status'] === 'completed' ? 'completed' : 'scheduled',
            'status' => 'shortlisted',
        ]);

        $this->sendInterviewEmails($interview->load('application.jobOpening.department'), $settings, $mailConfigurator, $emailCenter);

        return back()->with('status', 'Interview schedule created.');
    }

    public function updateInterview(
        Request $request,
        InterviewSchedule $interview,
        SiteSettingsService $settings,
        PlatformMailConfigurator $mailConfigurator,
        EmailCenterService $emailCenter,
    ): RedirectResponse {
        $data = $request->validate([
            'interviewer_name' => ['required', 'string', 'max:255'],
            'interviewer_email' => ['nullable', 'email'],
            'mode' => ['required', 'string', 'max:50'],
            'meeting_link' => ['nullable', 'url', 'max:1000'],
            'scheduled_for' => ['required', 'date'],
            'duration_minutes' => ['required', 'integer', 'min:15', 'max:240'],
            'stage' => ['required', 'string', 'max:50'],
            'status' => ['required', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
            'feedback' => ['nullable', 'string'],
        ]);

        $interview->update([
            ...$data,
            'completed_at' => $data['status'] === 'completed' ? now() : null,
        ]);

        $interview->application()->update([
            'interview_status' => $data['status'],
        ]);

        if ($data['status'] === 'scheduled') {
            $this->sendInterviewEmails($interview->load('application.jobOpening.department'), $settings, $mailConfigurator, $emailCenter);
        }

        return back()->with('status', 'Interview updated.');
    }

    public function storeCompensation(Request $request, ApprovalNotificationService $notifications): RedirectResponse
    {
        $data = $request->validate([
            'employee_profile_id' => ['required', 'exists:employee_profiles,id'],
            'title' => ['required', 'string', 'max:255'],
            'pay_type' => ['required', 'string', 'max:50'],
            'amount' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:10'],
            'effective_from' => ['required', 'date'],
            'effective_to' => ['nullable', 'date', 'after_or_equal:effective_from'],
            'status' => ['required', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
            'review_note' => ['nullable', 'string'],
        ]);

        $record = CompensationRecord::query()->create([
            ...$data,
            'created_by' => $request->user()?->id,
            ...$this->approvalFieldsForStatus($data['status'], $request->user()?->id, 'approved_by'),
        ]);

        $notifications->sendCompensationStatusUpdate($record->fresh(['employeeProfile.user']), $request->user());

        return back()->with('status', 'Compensation record added.');
    }

    public function updateCompensation(Request $request, CompensationRecord $record, ApprovalNotificationService $notifications): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'pay_type' => ['required', 'string', 'max:50'],
            'amount' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:10'],
            'effective_from' => ['required', 'date'],
            'effective_to' => ['nullable', 'date', 'after_or_equal:effective_from'],
            'status' => ['required', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
            'review_note' => ['nullable', 'string'],
        ]);

        $record->update([
            ...$data,
            ...$this->approvalFieldsForStatus($data['status'], $request->user()?->id, 'approved_by', $record->approved_by),
        ]);

        $notifications->sendCompensationStatusUpdate($record->fresh(['employeeProfile.user']), $request->user());

        return back()->with('status', 'Compensation record updated.');
    }

    public function storeExpense(Request $request, ApprovalNotificationService $notifications): RedirectResponse
    {
        $data = $request->validate([
            'employee_profile_id' => ['required', 'exists:employee_profiles,id'],
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'amount' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:10'],
            'expense_date' => ['required', 'date'],
            'status' => ['required', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
            'review_note' => ['nullable', 'string'],
        ]);

        $claim = ExpenseClaim::query()->create([
            ...$data,
            'submitted_by' => $request->user()?->id,
            'approved_by' => in_array($data['status'], ['approved', 'reimbursed', 'rejected'], true) ? $request->user()?->id : null,
            'processed_at' => in_array($data['status'], ['approved', 'reimbursed', 'rejected'], true) ? now() : null,
        ]);

        $notifications->sendExpenseStatusUpdate($claim->fresh(['employeeProfile.user']), $request->user());

        return back()->with('status', 'Expense claim added.');
    }

    public function updateExpense(Request $request, ExpenseClaim $claim, ApprovalNotificationService $notifications): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'amount' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:10'],
            'expense_date' => ['required', 'date'],
            'status' => ['required', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
            'review_note' => ['nullable', 'string'],
        ]);

        $claim->update([
            ...$data,
            'approved_by' => in_array($data['status'], ['approved', 'reimbursed', 'rejected'], true) ? $request->user()?->id : null,
            'processed_at' => in_array($data['status'], ['approved', 'reimbursed', 'rejected'], true) ? now() : null,
        ]);

        $notifications->sendExpenseStatusUpdate($claim->fresh(['employeeProfile.user']), $request->user());

        return back()->with('status', 'Expense claim updated.');
    }

    public function storePerk(Request $request, ApprovalNotificationService $notifications): RedirectResponse
    {
        $data = $request->validate([
            'employee_profile_id' => ['required', 'exists:employee_profiles,id'],
            'title' => ['required', 'string', 'max:255'],
            'perk_type' => ['required', 'string', 'max:100'],
            'value' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:50'],
            'starts_on' => ['nullable', 'date'],
            'ends_on' => ['nullable', 'date', 'after_or_equal:starts_on'],
            'notes' => ['nullable', 'string'],
            'review_note' => ['nullable', 'string'],
        ]);

        $perk = EmployeePerk::query()->create([
            ...$data,
            'created_by' => $request->user()?->id,
            ...$this->approvalFieldsForStatus($data['status'], $request->user()?->id, 'approved_by'),
        ]);

        $notifications->sendPerkStatusUpdate($perk->fresh(['employeeProfile.user']), $request->user());

        return back()->with('status', 'Perk added.');
    }

    public function updatePerk(Request $request, EmployeePerk $perk, ApprovalNotificationService $notifications): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'perk_type' => ['required', 'string', 'max:100'],
            'value' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:50'],
            'starts_on' => ['nullable', 'date'],
            'ends_on' => ['nullable', 'date', 'after_or_equal:starts_on'],
            'notes' => ['nullable', 'string'],
            'review_note' => ['nullable', 'string'],
        ]);

        $perk->update([
            ...$data,
            ...$this->approvalFieldsForStatus($data['status'], $request->user()?->id, 'approved_by', $perk->approved_by),
        ]);

        $notifications->sendPerkStatusUpdate($perk->fresh(['employeeProfile.user']), $request->user());

        return back()->with('status', 'Perk updated.');
    }

    private function approvalFieldsForStatus(string $status, ?int $userId, string $approverColumn, ?int $existingApproverId = null): array
    {
        $approvedStates = ['approved', 'active', 'reimbursed'];
        $decisionStates = [...$approvedStates, 'rejected'];

        return [
            $approverColumn => in_array($status, $decisionStates, true) ? ($userId ?? $existingApproverId) : null,
            'approved_at' => in_array($status, $approvedStates, true) ? now() : null,
        ];
    }

    private function mapJobData(array $data, ?JobOpening $jobOpening = null): array
    {
        $title = trim($data['title']);

        return [
            'department_id' => $data['department_id'] ?? null,
            'title' => $title,
            'slug' => $jobOpening?->slug ?? $this->uniqueSlug($title),
            'location' => $data['location'] ?? null,
            'employment_type' => $data['employment_type'],
            'description' => $data['description'] ?? null,
            'salary_min' => $data['salary_min'] ?? null,
            'salary_max' => $data['salary_max'] ?? null,
            'salary_currency' => $data['salary_currency'] ?? null,
            'experience_min' => $data['experience_min'] ?? null,
            'experience_max' => $data['experience_max'] ?? null,
            'notice_period' => $data['notice_period'] ?? null,
            'immediate_joiner_preferred' => array_key_exists('immediate_joiner_preferred', $data),
            'skills' => $this->linesToArray($data['skills'] ?? null),
            'application_questions' => $this->linesToArray($data['application_questions'] ?? null),
            'is_published' => array_key_exists('is_published', $data),
            'published_at' => array_key_exists('is_published', $data) ? ($jobOpening?->published_at ?? now()) : null,
        ];
    }

    private function linesToArray(?string $value): ?array
    {
        if (! $value) {
            return null;
        }

        $items = collect(preg_split('/\r\n|\r|\n/', $value))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();

        return $items ?: null;
    }

    private function uniqueSlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 2;

        while (JobOpening::query()->where('slug', $slug)->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    private function sendInterviewEmails(
        InterviewSchedule $interview,
        SiteSettingsService $settings,
        PlatformMailConfigurator $mailConfigurator,
        EmailCenterService $emailCenter,
    ): void {
        try {
            if (! $mailConfigurator->apply('hr')) {
                return;
            }

            $candidateSent = $emailCenter->sendTemplate(
                slug: 'interview-scheduled-candidate',
                recipientEmail: $interview->application->email,
                recipientName: $interview->application->name,
                variables: [
                    'name' => $interview->application->name,
                    'job_title' => $interview->application->jobOpening?->title,
                    'interview_date' => $interview->scheduled_for?->format('d M Y, h:i A'),
                    'interviewer_name' => $interview->interviewer_name,
                    'meeting_link' => $interview->meeting_link ?? '',
                    'stage' => str($interview->stage)->replace('_', ' ')->title(),
                    'mode' => str($interview->mode)->replace('_', ' ')->title(),
                ],
                meta: ['type' => 'hr_candidate_interview'],
                scope: 'hr',
            );

            if (! $candidateSent) {
                Mail::to($interview->application->email)->send(new CandidateInterviewScheduled($interview));
            }

            $mailSettings = $settings->getHrMailSettings();
            $internalRecipients = collect([
                $mailSettings['hr_recruitment_email'] ?? null,
                $mailSettings['admin_alert_email'] ?? null,
            ])->filter()->unique()->values()->all();

            if ($internalRecipients) {
                $internalSent = true;

                foreach ($internalRecipients as $recipient) {
                    $internalSent = $emailCenter->sendTemplate(
                        slug: 'interview-scheduled-internal',
                        recipientEmail: $recipient,
                        recipientName: null,
                        variables: [
                            'candidate_name' => $interview->application->name,
                            'candidate_email' => $interview->application->email,
                            'job_title' => $interview->application->jobOpening?->title,
                            'interview_date' => $interview->scheduled_for?->format('d M Y, h:i A'),
                            'interviewer_name' => $interview->interviewer_name,
                            'meeting_link' => $interview->meeting_link ?? '',
                            'stage' => str($interview->stage)->replace('_', ' ')->title(),
                        ],
                        meta: ['type' => 'hr_internal_interview'],
                        scope: 'hr',
                    ) && $internalSent;
                }

                if (! $internalSent) {
                    Mail::to($internalRecipients)->send(new InternalInterviewScheduled($interview));
                }
            }
        } catch (\Throwable $exception) {
            Log::warning('Failed to send interview emails.', [
                'interview_id' => $interview->id,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
