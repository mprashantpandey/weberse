<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LeadStage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreFollowUpRequest;
use App\Http\Requests\Admin\StoreLeadNoteRequest;
use App\Http\Requests\Admin\StoreLeadRequest;
use App\Http\Requests\Admin\UpdateContactRequest;
use App\Http\Requests\Admin\UpdateFollowUpRequest;
use App\Http\Requests\Admin\UpdateLeadRequest;
use App\Models\CRM\Contact;
use App\Models\CRM\FollowUp;
use App\Models\CRM\Lead;
use App\Models\User;
use App\Services\CRM\LeadPipelineService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CrmController extends Controller
{
    public function __construct(private readonly LeadPipelineService $leadPipelineService) {}

    public function index(): View
    {
        $stageSummary = collect(LeadStage::cases())->map(function (LeadStage $stage) {
            $query = Lead::query()->where('stage', $stage->value);

            return [
                'label' => str($stage->value)->replace('_', ' ')->title(),
                'count' => (clone $query)->count(),
                'value' => (float) (clone $query)->sum('estimated_value'),
            ];
        });

        return view('admin.crm.index', [
            'summary' => [
                'open_leads' => Lead::query()->whereNotIn('status', ['won', 'lost'])->count(),
                'pipeline_value' => Lead::query()->whereNotIn('status', ['won', 'lost'])->sum('estimated_value'),
                'due_follow_ups' => FollowUp::query()->where('status', '!=', 'completed')->where('due_at', '<=', now())->count(),
                'won_this_month' => Lead::query()->where('stage', LeadStage::ClosedWon->value)->whereMonth('updated_at', now()->month)->count(),
            ],
            'stageSummary' => $stageSummary,
            'dueFollowUps' => FollowUp::query()->with(['lead', 'assignee'])->where('status', '!=', 'completed')->orderBy('due_at')->take(6)->get(),
            'recentLeads' => Lead::query()->with(['contact'])->latest()->take(6)->get(),
            'recentContacts' => Contact::query()->withCount('leads')->latest()->take(6)->get(),
        ]);
    }

    public function leads(Request $request): View
    {
        $leads = Lead::query()
            ->with(['contact', 'owner'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = (string) $request->string('q');

                $query->where(function ($subquery) use ($term) {
                    $subquery
                        ->where('title', 'like', "%{$term}%")
                        ->orWhere('source', 'like', "%{$term}%")
                        ->orWhereHas('contact', function ($contactQuery) use ($term) {
                            $contactQuery
                                ->where('name', 'like', "%{$term}%")
                                ->orWhere('company', 'like', "%{$term}%")
                                ->orWhere('email', 'like', "%{$term}%");
                        });
                });
            })
            ->when($request->filled('stage'), fn ($query) => $query->where('stage', (string) $request->string('stage')))
            ->when($request->filled('owner'), fn ($query) => $query->where('owner_id', $request->integer('owner')))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.crm.leads', [
            'leads' => $leads,
            'salesUsers' => User::role(['admin', 'sales'])->orderBy('name')->get(),
            'stages' => LeadStage::cases(),
        ]);
    }

    public function create(): View
    {
        return view('admin.crm.lead-form', [
            'mode' => 'create',
            'lead' => new Lead(['stage' => LeadStage::Lead->value, 'status' => 'open']),
            'salesUsers' => User::role(['admin', 'sales'])->orderBy('name')->get(),
            'stages' => LeadStage::cases(),
        ]);
    }

    public function show(Lead $lead): View
    {
        return view('admin.crm.lead-show', [
            'lead' => $lead->load(['contact', 'owner', 'notes.user', 'followUps.assignee']),
            'salesUsers' => User::role(['admin', 'sales'])->orderBy('name')->get(),
        ]);
    }

    public function edit(Lead $lead): View
    {
        return view('admin.crm.lead-form', [
            'mode' => 'edit',
            'lead' => $lead->load('contact'),
            'salesUsers' => User::role(['admin', 'sales'])->orderBy('name')->get(),
            'stages' => LeadStage::cases(),
        ]);
    }

    public function store(StoreLeadRequest $request): RedirectResponse
    {
        $lead = $this->leadPipelineService->createLead($request->validated(), $request->user());

        return redirect()->route('admin.crm.leads.show', $lead)->with('status', 'Lead created successfully.');
    }

    public function update(UpdateLeadRequest $request, Lead $lead): RedirectResponse
    {
        if ($lead->contact) {
            $contactPayload = collect($request->validated())
                ->only(['name', 'email', 'phone', 'company', 'designation'])
                ->filter(fn ($value) => $value !== null)
                ->all();

            if ($contactPayload !== []) {
                $this->leadPipelineService->updateContact($lead->contact, $contactPayload, $request->user());
            }
        }

        $this->leadPipelineService->updateLead($lead, $request->validated(), $request->user());

        return redirect()->route('admin.crm.leads.show', $lead)->with('status', 'Lead updated successfully.');
    }

    public function addNote(StoreLeadNoteRequest $request, Lead $lead): RedirectResponse
    {
        $this->leadPipelineService->addNote($lead, $request->validated()['body'], $request->user());

        return back()->with('status', 'Lead note added.');
    }

    public function contacts(Request $request): View
    {
        $contacts = Contact::query()
            ->withCount('leads')
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = (string) $request->string('q');
                $query->where(function ($subquery) use ($term) {
                    $subquery
                        ->where('name', 'like', "%{$term}%")
                        ->orWhere('company', 'like', "%{$term}%")
                        ->orWhere('email', 'like', "%{$term}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.crm.contacts', [
            'contacts' => $contacts,
        ]);
    }

    public function updateContact(UpdateContactRequest $request, Contact $contact): RedirectResponse
    {
        $this->leadPipelineService->updateContact($contact, $request->validated(), $request->user());

        return back()->with('status', 'Contact updated successfully.');
    }

    public function followUps(): View
    {
        return view('admin.crm.follow-ups', [
            'followUps' => FollowUp::query()->with(['lead.contact', 'assignee'])->orderBy('due_at')->paginate(12),
            'leadOptions' => Lead::query()->with('contact')->orderBy('title')->get(),
            'salesUsers' => User::role(['admin', 'sales'])->orderBy('name')->get(),
        ]);
    }

    public function storeFollowUp(StoreFollowUpRequest $request): RedirectResponse
    {
        $this->leadPipelineService->createFollowUp($request->validated(), $request->user());

        return back()->with('status', 'Follow-up created successfully.');
    }

    public function updateFollowUp(UpdateFollowUpRequest $request, FollowUp $followUp): RedirectResponse
    {
        $this->leadPipelineService->updateFollowUp($followUp, $request->validated(), $request->user());

        return back()->with('status', 'Follow-up updated successfully.');
    }
}
