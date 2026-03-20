<?php

namespace App\Http\Controllers\Website;

use App\Enums\LeadStage;
use App\Http\Controllers\Controller;
use App\Mail\CandidateApplicationReceived;
use App\Mail\InternalApplicationReceived;
use App\Models\Communication\NewsletterSubscriber;
use App\Models\CRM\Contact;
use App\Models\CRM\Lead;
use App\Models\HRM\JobApplication;
use App\Models\HRM\JobOpening;
use App\Services\Communication\EmailCenterService;
use App\Services\Mail\PlatformMailConfigurator;
use App\Services\Settings\SiteSettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\JsonResponse;

class FormController extends Controller
{
    public function contact(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'company' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'source' => ['nullable', 'string', 'max:100'],
            'title' => ['nullable', 'string', 'max:255'],
            'popup_form' => ['nullable'],
        ]);

        $contact = Contact::query()->firstOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['name'],
                'phone' => $data['phone'] ?? null,
                'company' => $data['company'] ?? null,
            ]
        );

        Lead::query()->create([
            'contact_id' => $contact->id,
            'title' => $data['title'] ?? 'Website inquiry from '.$data['name'],
            'source' => $data['source'] ?? 'website_form',
            'stage' => LeadStage::Lead->value,
            'message' => $data['message'],
        ]);

        $redirect = back()->with('status', 'Your inquiry has been submitted.');

        // If the lead came from the instant popup form, keep old() values
        // so the modal can reopen and show the success state.
        if (! empty($data['popup_form'])) {
            return $redirect->withInput();
        }

        return $redirect;
    }

    public function whmcsLead(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'company' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'title' => ['nullable', 'string', 'max:255'],
        ]);

        $contact = Contact::query()->firstOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['name'],
                'phone' => $data['phone'] ?? null,
                'company' => $data['company'] ?? null,
            ]
        );

        Lead::query()->create([
            'contact_id' => $contact->id,
            'title' => $data['title'] ?? 'WHMCS inquiry from '.$data['name'],
            'source' => 'whmcs',
            'stage' => LeadStage::Lead->value,
            'message' => $data['message'],
        ]);

        return response()->json([
            'ok' => true,
            'message' => 'Thanks! Your request has been received.',
        ]);
    }

    public function apply(
        Request $request,
        ?JobOpening $jobOpening = null,
        SiteSettingsService $settings,
        PlatformMailConfigurator $mailConfigurator,
        EmailCenterService $emailCenter,
    ): RedirectResponse
    {
        abort_unless($settings->featureEnabled('careers_enabled'), 404);

        $data = $request->validate([
            'job_opening' => ['nullable', 'string', 'exists:job_openings,slug'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'notice_period_response' => ['nullable', 'string', 'max:100'],
            'cover_letter' => ['nullable', 'string'],
            'application_answers' => ['nullable', 'array'],
            'application_answers.*' => ['nullable', 'string'],
            'resume' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $jobOpening ??= JobOpening::query()
            ->where('slug', $data['job_opening'] ?? null)
            ->firstOrFail();

        $application = JobApplication::query()->create([
            'job_opening_id' => $jobOpening->id,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'notice_period_response' => $data['notice_period_response'] ?? null,
            'cover_letter' => $data['cover_letter'] ?? null,
            'application_answers' => $this->normalizeApplicationAnswers($jobOpening, $data['application_answers'] ?? []),
            'resume_path' => $request->file('resume')?->store('resumes', 'public'),
            'status' => 'applied',
            'interview_status' => 'not_scheduled',
        ]);

        $this->sendApplicationEmails($application->load('jobOpening.department'), $settings, $mailConfigurator, $emailCenter);

        return back()->with('status', 'Application submitted successfully.');
    }

    public function newsletter(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'name' => ['nullable', 'string', 'max:255'],
        ]);

        NewsletterSubscriber::query()->updateOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['name'] ?? null,
                'status' => 'active',
                'source' => 'website_footer',
                'subscribed_at' => now(),
                'unsubscribed_at' => null,
            ]
        );

        return back()->with('status', 'You have been subscribed to the newsletter.');
    }

    private function normalizeApplicationAnswers(JobOpening $jobOpening, array $answers): ?array
    {
        $questions = collect($jobOpening->application_questions ?? []);

        $mapped = $questions
            ->mapWithKeys(fn ($question, $index) => [
                $question => trim((string) ($answers[$index] ?? '')),
            ])
            ->filter(fn ($answer) => $answer !== '')
            ->all();

        return $mapped ?: null;
    }

    private function sendApplicationEmails(
        JobApplication $application,
        SiteSettingsService $settings,
        PlatformMailConfigurator $mailConfigurator,
        EmailCenterService $emailCenter,
    ): void {
        try {
            if (! $mailConfigurator->apply('hr')) {
                return;
            }

            $candidateSent = $emailCenter->sendTemplate(
                slug: 'application-received-candidate',
                recipientEmail: $application->email,
                recipientName: $application->name,
                variables: [
                    'name' => $application->name,
                    'job_title' => $application->jobOpening?->title,
                    'department' => $application->jobOpening?->department?->name ?? 'General',
                ],
                meta: ['type' => 'hr_candidate_application'],
                scope: 'hr',
            );

            if (! $candidateSent) {
                Mail::to($application->email)->send(new CandidateApplicationReceived($application));
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
                        slug: 'application-received-internal',
                        recipientEmail: $recipient,
                        recipientName: null,
                        variables: [
                            'candidate_name' => $application->name,
                            'candidate_email' => $application->email,
                            'job_title' => $application->jobOpening?->title,
                            'department' => $application->jobOpening?->department?->name ?? 'General',
                            'notice_period' => $application->notice_period_response ?: 'Not provided',
                        ],
                        meta: ['type' => 'hr_internal_application'],
                        scope: 'hr',
                    ) && $internalSent;
                }

                if (! $internalSent) {
                    Mail::to($internalRecipients)->send(new InternalApplicationReceived($application));
                }
            }
        } catch (\Throwable $exception) {
            Log::warning('Failed to send job application emails.', [
                'application_id' => $application->id,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
