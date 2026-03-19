@extends('layouts.dashboard', [
    'title' => 'HRM Compensation',
    'heading' => 'Compensation',
    'subheading' => 'Salary and pay records kept separate from employee profile basics.',
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
        <a href="{{ route('admin.hrm.approvals.index') }}" class="dashboard-subnav-link">Approvals</a>
        <a href="{{ route('admin.hrm.employees.index') }}" class="dashboard-subnav-link">Employees</a>
        <a href="{{ route('admin.hrm.jobs.index') }}" class="dashboard-subnav-link">Jobs</a>
        <a href="{{ route('admin.hrm.applications.index') }}" class="dashboard-subnav-link">Applications</a>
        <a href="{{ route('admin.hrm.interviews.index') }}" class="dashboard-subnav-link">Interviews</a>
        <a href="{{ route('admin.hrm.compensation.index') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Compensation</a>
        <a href="{{ route('admin.hrm.expenses.index') }}" class="dashboard-subnav-link">Expenses</a>
        <a href="{{ route('admin.hrm.perks.index') }}" class="dashboard-subnav-link">Perks</a>
    </div>

    <div class="card card-modal-host" x-data="{ createOpen: false, activeEdit: null }">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="panel-title">Compensation Records</div>
                <div class="panel-subtitle">Keep salary, retainer, and allowance history in a dedicated table.</div>
            </div>
            <button type="button" class="btn-primary" @click="createOpen = true">Add Record</button>
        </div>
        <div class="mt-6 overflow-x-auto">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Title</th>
                        <th>Amount</th>
                        <th>Effective</th>
                        <th>Status</th>
                        <th>Approval</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $record)
                        <tr>
                            <td>{{ $record->employeeProfile?->user?->name }}</td>
                            <td>{{ $record->title }}</td>
                            <td>{{ $record->currency }} {{ number_format((float) $record->amount, 2) }}</td>
                            <td>{{ $record->effective_from?->format('d M Y') }}</td>
                            <td><span class="status-badge">{{ str($record->status)->replace('_', ' ')->title() }}</span></td>
                            <td>
                                <div>{{ $record->approver?->name ?: ($record->creator?->name ? 'Created by '.$record->creator->name : '—') }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ $record->review_note ?: 'No approval note' }}</div>
                            </td>
                            <td class="text-right"><button type="button" class="btn-dark px-4 py-2 text-xs" @click="activeEdit = {{ $record->id }}">Edit</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div x-show="createOpen" x-cloak class="dashboard-modal-backdrop" @click.self="createOpen = false">
            <div class="dashboard-modal-card">
                <div class="flex items-center justify-between gap-4">
                    <div class="panel-title">Add Compensation Record</div>
                    <button type="button" class="btn-dark px-4 py-2 text-xs" @click="createOpen = false">Close</button>
                </div>
                <form method="POST" action="{{ route('admin.hrm.compensation.store') }}" class="mt-6 grid gap-4 md:grid-cols-2">
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
                    <input class="input" name="title" placeholder="Monthly salary" required>
                    <select class="input" name="pay_type">
                        @foreach (['monthly_salary', 'bonus', 'retainer', 'allowance'] as $type)
                            <option value="{{ $type }}">{{ str($type)->replace('_', ' ')->title() }}</option>
                        @endforeach
                    </select>
                    <input class="input" type="number" step="0.01" min="0" name="amount" placeholder="Amount" required>
                    <input class="input" name="currency" value="INR" required>
                    <input class="input" type="date" name="effective_from" required>
                    <select class="input" name="status">
                        @foreach (['pending_approval', 'approved', 'active', 'scheduled', 'closed', 'rejected'] as $status)
                            <option value="{{ $status }}">{{ str($status)->replace('_', ' ')->title() }}</option>
                        @endforeach
                    </select>
                    <textarea class="input min-h-28 md:col-span-2" name="notes" placeholder="Notes"></textarea>
                    <textarea class="input min-h-28 md:col-span-2" name="review_note" placeholder="Approval note"></textarea>
                    <div class="md:col-span-2 flex gap-3">
                        <button class="btn-primary">Save Record</button>
                        <button type="button" class="btn-dark" @click="createOpen = false">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        @foreach ($records as $record)
            <div x-show="activeEdit === {{ $record->id }}" x-cloak class="dashboard-modal-backdrop" @click.self="activeEdit = null">
                <div class="dashboard-modal-card">
                    <div class="flex items-center justify-between gap-4">
                        <div class="panel-title">Edit Compensation Record</div>
                        <button type="button" class="btn-dark px-4 py-2 text-xs" @click="activeEdit = null">Close</button>
                    </div>
                    <form method="POST" action="{{ route('admin.hrm.compensation.update', $record) }}" class="mt-6 grid gap-4 md:grid-cols-2">
                        @csrf
                        @method('PATCH')
                        <input class="input" name="title" value="{{ $record->title }}" required>
                        <select class="input" name="pay_type">
                            @foreach (['monthly_salary', 'bonus', 'retainer', 'allowance'] as $type)
                                <option value="{{ $type }}" @selected($record->pay_type === $type)>{{ str($type)->replace('_', ' ')->title() }}</option>
                            @endforeach
                        </select>
                        <input class="input" type="number" step="0.01" min="0" name="amount" value="{{ $record->amount }}" required>
                        <input class="input" name="currency" value="{{ $record->currency }}" required>
                        <input class="input" type="date" name="effective_from" value="{{ optional($record->effective_from)->format('Y-m-d') }}" required>
                        <select class="input" name="status">
                            @foreach (['pending_approval', 'approved', 'active', 'scheduled', 'closed', 'rejected'] as $status)
                                <option value="{{ $status }}" @selected($record->status === $status)>{{ str($status)->replace('_', ' ')->title() }}</option>
                            @endforeach
                        </select>
                        <textarea class="input min-h-28 md:col-span-2" name="notes">{{ $record->notes }}</textarea>
                        <textarea class="input min-h-28 md:col-span-2" name="review_note">{{ $record->review_note }}</textarea>
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
