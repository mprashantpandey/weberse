<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Communication\EmailTemplate;
use App\Models\Communication\NewsletterCampaign;
use App\Models\Communication\NewsletterSubscriber;
use App\Models\Communication\OutboundEmail;
use App\Services\Communication\EmailCenterService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EmailController extends Controller
{
    public function index(): View
    {
        return view('admin.email.index', [
            'summary' => [
                'templates' => EmailTemplate::query()->count(),
                'subscribers' => NewsletterSubscriber::query()->where('status', 'active')->count(),
                'campaigns' => NewsletterCampaign::query()->count(),
                'sent' => OutboundEmail::query()->where('status', 'sent')->count(),
            ],
            'recentCampaigns' => NewsletterCampaign::query()->latest()->take(5)->get(),
            'recentEmails' => OutboundEmail::query()->latest()->take(8)->get(),
        ]);
    }

    public function templates(): View
    {
        return view('admin.email.templates', [
            'templates' => EmailTemplate::query()->latest()->get(),
        ]);
    }

    public function createTemplate(): View
    {
        return view('admin.email.template-form', [
            'template' => new EmailTemplate(['is_active' => true, 'category' => 'general']),
            'mode' => 'create',
        ]);
    }

    public function editTemplate(EmailTemplate $template): View
    {
        return view('admin.email.template-form', [
            'template' => $template,
            'mode' => 'edit',
        ]);
    }

    public function subscribers(): View
    {
        return view('admin.email.subscribers', [
            'subscribers' => NewsletterSubscriber::query()->latest()->get(),
        ]);
    }

    public function campaigns(): View
    {
        return view('admin.email.campaigns', [
            'campaigns' => NewsletterCampaign::query()->with('template')->latest()->get(),
            'templates' => EmailTemplate::query()->where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function createCampaign(): View
    {
        return view('admin.email.campaign-form', [
            'campaign' => new NewsletterCampaign(['status' => 'draft', 'target_segment' => 'all_active']),
            'templates' => EmailTemplate::query()->where('is_active', true)->orderBy('name')->get(),
            'mode' => 'create',
        ]);
    }

    public function editCampaign(NewsletterCampaign $campaign): View
    {
        return view('admin.email.campaign-form', [
            'campaign' => $campaign->load('template'),
            'templates' => EmailTemplate::query()->where('is_active', true)->orderBy('name')->get(),
            'mode' => 'edit',
        ]);
    }

    public function composer(): View
    {
        return view('admin.email.compose', [
            'templates' => EmailTemplate::query()->where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function storeTemplate(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable'],
        ]);

        EmailTemplate::query()->create([
            ...$data,
            'slug' => $this->uniqueSlug($data['name']),
            'is_active' => array_key_exists('is_active', $data),
        ]);

        return redirect()->route('admin.email.templates.index')->with('status', 'Email template created.');
    }

    public function updateTemplate(Request $request, EmailTemplate $template): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable'],
        ]);

        $template->update([
            ...$data,
            'is_active' => array_key_exists('is_active', $data),
        ]);

        return back()->with('status', 'Email template updated.');
    }

    public function storeSubscriber(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'status' => ['required', 'string', 'max:50'],
            'source' => ['nullable', 'string', 'max:100'],
        ]);

        NewsletterSubscriber::query()->updateOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['name'] ?? null,
                'status' => $data['status'],
                'source' => $data['source'] ?? 'admin',
                'subscribed_at' => now(),
                'unsubscribed_at' => $data['status'] === 'unsubscribed' ? now() : null,
            ]
        );

        return back()->with('status', 'Subscriber saved.');
    }

    public function updateSubscriber(Request $request, NewsletterSubscriber $subscriber): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:50'],
            'source' => ['nullable', 'string', 'max:100'],
        ]);

        $subscriber->update([
            'name' => $data['name'] ?? null,
            'status' => $data['status'],
            'source' => $data['source'] ?? $subscriber->source,
            'unsubscribed_at' => $data['status'] === 'unsubscribed' ? ($subscriber->unsubscribed_at ?? now()) : null,
        ]);

        return back()->with('status', 'Subscriber updated.');
    }

    public function storeCampaign(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email_template_id' => ['nullable', 'exists:email_templates,id'],
            'title' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'target_segment' => ['required', 'string', 'max:100'],
            'status' => ['required', 'string', 'max:50'],
        ]);

        NewsletterCampaign::query()->create($data);

        return redirect()->route('admin.email.campaigns.index')->with('status', 'Newsletter campaign created.');
    }

    public function updateCampaign(Request $request, NewsletterCampaign $campaign): RedirectResponse
    {
        $data = $request->validate([
            'email_template_id' => ['nullable', 'exists:email_templates,id'],
            'title' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'target_segment' => ['required', 'string', 'max:100'],
            'status' => ['required', 'string', 'max:50'],
        ]);

        $campaign->update($data);

        return back()->with('status', 'Newsletter campaign updated.');
    }

    public function sendCampaign(NewsletterCampaign $campaign, EmailCenterService $service, Request $request): RedirectResponse
    {
        $sent = $service->sendCampaign($campaign, $request->user());

        return back()->with('status', "Campaign sent to {$sent} subscribers.");
    }

    public function sendSingle(Request $request, EmailCenterService $service): RedirectResponse
    {
        $data = $request->validate([
            'template_id' => ['nullable', 'exists:email_templates,id'],
            'recipient_name' => ['nullable', 'string', 'max:255'],
            'recipient_email' => ['required', 'email'],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        $template = ! empty($data['template_id'])
            ? EmailTemplate::query()->find($data['template_id'])
            : null;

        $ok = $service->sendDirect(
            recipientEmail: $data['recipient_email'],
            recipientName: $data['recipient_name'] ?? null,
            subject: $data['subject'],
            body: $data['body'],
            sender: $request->user(),
            template: $template,
            meta: ['type' => 'single_send'],
        );

        return back()->with('status', $ok ? 'Email sent successfully.' : 'Email could not be sent. Check SMTP settings.');
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $counter = 2;

        while (EmailTemplate::query()->where('slug', $slug)->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
