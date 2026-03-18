<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\ClientDocument;
use App\Models\Support\SupportTicket;
use App\Models\User;
use App\Services\WHMCS\WhmcsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ClientManagementController extends Controller
{
    public function index(): View
    {
        return view('admin.clients.index', [
            'clients' => User::query()
                ->role(UserRole::Client->value)
                ->withCount(['supportTickets'])
                ->latest()
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.clients.form', [
            'client' => new User(['is_active' => true]),
            'mode' => 'create',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedClientData($request);

        $client = User::query()->create([
            ...$data,
            'password' => Hash::make($data['password']),
        ]);
        $client->assignRole(UserRole::Client->value);

        return redirect()->route('admin.clients.show', $client)->with('status', 'Client account created.');
    }

    public function show(User $client, WhmcsService $whmcs): View
    {
        abort_unless($client->hasRole(UserRole::Client->value), 404);

        return view('admin.clients.show', [
            'client' => $client->loadCount(['supportTickets']),
            'documents' => ClientDocument::query()->where('user_id', $client->id)->latest()->get(),
            'tickets' => SupportTicket::query()->where('user_id', $client->id)->with(['department', 'assignee'])->latest()->take(10)->get(),
            'whmcsSummary' => $client->whmcs_client_id ? $whmcs->clientSummaryById($client->whmcs_client_id) : null,
        ]);
    }

    public function edit(User $client): View
    {
        abort_unless($client->hasRole(UserRole::Client->value), 404);

        return view('admin.clients.form', [
            'client' => $client,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, User $client): RedirectResponse
    {
        abort_unless($client->hasRole(UserRole::Client->value), 404);

        $data = $this->validatedClientData($request, $client);

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $client->update($data);

        return back()->with('status', 'Client account updated.');
    }

    public function storeDocument(Request $request, User $client): RedirectResponse
    {
        abort_unless($client->hasRole(UserRole::Client->value), 404);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'visibility' => ['required', 'string', 'max:50'],
            'file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,doc,docx,webp', 'max:8192'],
        ]);

        ClientDocument::query()->create([
            'user_id' => $client->id,
            'title' => $data['title'],
            'notes' => $data['notes'] ?? null,
            'visibility' => $data['visibility'],
            'file_path' => $request->file('file')?->store('client-documents', 'public'),
        ]);

        return back()->with('status', 'Client document added.');
    }

    protected function validatedClientData(Request $request, ?User $client = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($client?->id)],
            'phone' => ['nullable', 'string', 'max:50'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'whmcs_client_id' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable'],
            'password' => [$client ? 'nullable' : 'required', 'string', 'min:6', 'max:255'],
        ]) + [
            'is_active' => $request->boolean('is_active'),
        ];
    }
}
