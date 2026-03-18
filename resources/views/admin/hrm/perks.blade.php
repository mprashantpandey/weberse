@extends('layouts.dashboard', [
    'title' => 'HRM Perks',
    'heading' => 'Employee Perks',
    'subheading' => 'Small benefit records are easier to manage through table + modal editing.',
    'nav' => [
        ['label' => 'Overview', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard'],
        ['label' => 'CMS', 'route' => 'admin.cms.index', 'active' => 'admin.cms.*'],
        ['label' => 'CRM', 'route' => 'admin.crm.index', 'active' => 'admin.crm.*'],
        ['label' => 'HRM', 'route' => 'admin.hrm.index', 'active' => 'admin.hrm.*'],
        ['label' => 'Support', 'route' => 'admin.support.index', 'active' => 'admin.support.*'],
        ['label' => 'Analytics', 'route' => 'admin.analytics.index', 'active' => 'admin.analytics.*'],
    ],
])

@section('content')
    @if (session('status'))
        <div class="card mb-6 border border-green-200 bg-green-50 text-green-700">{{ session('status') }}</div>
    @endif

    <div class="dashboard-subnav">
        <a href="{{ route('admin.hrm.index') }}" class="dashboard-subnav-link">Overview</a>
        <a href="{{ route('admin.hrm.employees.index') }}" class="dashboard-subnav-link">Employees</a>
        <a href="{{ route('admin.hrm.jobs.index') }}" class="dashboard-subnav-link">Jobs</a>
        <a href="{{ route('admin.hrm.applications.index') }}" class="dashboard-subnav-link">Applications</a>
        <a href="{{ route('admin.hrm.interviews.index') }}" class="dashboard-subnav-link">Interviews</a>
        <a href="{{ route('admin.hrm.compensation.index') }}" class="dashboard-subnav-link">Compensation</a>
        <a href="{{ route('admin.hrm.expenses.index') }}" class="dashboard-subnav-link">Expenses</a>
        <a href="{{ route('admin.hrm.perks.index') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Perks</a>
    </div>

    <div class="card card-modal-host" x-data="{ createOpen: false, activeEdit: null }">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="panel-title">Perks & Benefits</div>
                <div class="panel-subtitle">Keep smaller benefit records lightweight and editable in-place.</div>
            </div>
            <button type="button" class="btn-primary" @click="createOpen = true">Add Perk</button>
        </div>
        <div class="mt-6 overflow-x-auto">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Perk</th>
                        <th>Value</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($perks as $perk)
                        <tr>
                            <td>{{ $perk->employeeProfile?->user?->name }}</td>
                            <td>{{ $perk->title }} <div class="mt-1 text-xs text-slate-500">{{ str($perk->perk_type)->replace('_', ' ')->title() }}</div></td>
                            <td>{{ $perk->value ?: '—' }}</td>
                            <td><span class="status-badge">{{ str($perk->status)->replace('_', ' ')->title() }}</span></td>
                            <td class="text-right"><button type="button" class="btn-dark px-4 py-2 text-xs" @click="activeEdit = {{ $perk->id }}">Edit</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div x-show="createOpen" x-cloak class="dashboard-modal-backdrop" @click.self="createOpen = false">
            <div class="dashboard-modal-card">
                <div class="flex items-center justify-between gap-4">
                    <div class="panel-title">Add Perk</div>
                    <button type="button" class="btn-dark px-4 py-2 text-xs" @click="createOpen = false">Close</button>
                </div>
                <form method="POST" action="{{ route('admin.hrm.perks.store') }}" class="mt-6 grid gap-4 md:grid-cols-2">
                    @csrf
                    <label class="block md:col-span-2">
                        <span class="text-sm font-medium text-slate-700">Employee</span>
                        <select class="input mt-2" name="employee_profile_id" required>
                            <option value="">Select employee</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->user?->name }} • {{ $employee->employee_code }}</option>
                            @endforeach
                        </select>
                    </label>
                    <input class="input" name="title" placeholder="Health insurance" required>
                    <input class="input" name="perk_type" placeholder="Benefit type" required>
                    <input class="input" name="value" placeholder="Family cover">
                    <select class="input" name="status">
                        @foreach (['active', 'inactive', 'planned'] as $status)
                            <option value="{{ $status }}">{{ str($status)->title() }}</option>
                        @endforeach
                    </select>
                    <textarea class="input min-h-28 md:col-span-2" name="notes" placeholder="Notes"></textarea>
                    <div class="md:col-span-2 flex gap-3">
                        <button class="btn-primary">Save Perk</button>
                        <button type="button" class="btn-dark" @click="createOpen = false">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        @foreach ($perks as $perk)
            <div x-show="activeEdit === {{ $perk->id }}" x-cloak class="dashboard-modal-backdrop" @click.self="activeEdit = null">
                <div class="dashboard-modal-card">
                    <div class="flex items-center justify-between gap-4">
                        <div class="panel-title">Edit Perk</div>
                        <button type="button" class="btn-dark px-4 py-2 text-xs" @click="activeEdit = null">Close</button>
                    </div>
                    <form method="POST" action="{{ route('admin.hrm.perks.update', $perk) }}" class="mt-6 grid gap-4 md:grid-cols-2">
                        @csrf
                        @method('PATCH')
                        <input class="input" name="title" value="{{ $perk->title }}" required>
                        <input class="input" name="perk_type" value="{{ $perk->perk_type }}" required>
                        <input class="input" name="value" value="{{ $perk->value }}">
                        <select class="input" name="status">
                            @foreach (['active', 'inactive', 'planned'] as $status)
                                <option value="{{ $status }}" @selected($perk->status === $status)>{{ str($status)->title() }}</option>
                            @endforeach
                        </select>
                        <textarea class="input min-h-28 md:col-span-2" name="notes">{{ $perk->notes }}</textarea>
                        <div class="md:col-span-2 flex gap-3">
                            <button class="btn-primary">Save Changes</button>
                            <button type="button" class="btn-dark" @click="activeEdit = null">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
