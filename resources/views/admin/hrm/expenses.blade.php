@extends('layouts.dashboard', [
    'title' => 'HRM Expenses',
    'heading' => 'Expense Management',
    'subheading' => 'Track claims, reimbursements, and approvals without mixing them into employee notes.',
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
        <a href="{{ route('admin.hrm.expenses.index') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Expenses</a>
        <a href="{{ route('admin.hrm.perks.index') }}" class="dashboard-subnav-link">Perks</a>
    </div>

    <div class="card card-modal-host" x-data="{ createOpen: false, activeEdit: null }">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="panel-title">Expense Claims</div>
                <div class="panel-subtitle">Submit, review, approve, and reimburse team expenses in one clean table.</div>
            </div>
            <button type="button" class="btn-primary" @click="createOpen = true">Add Claim</button>
        </div>
        <div class="mt-6 overflow-x-auto">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Expense</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($claims as $claim)
                        <tr>
                            <td>{{ $claim->employeeProfile?->user?->name }}</td>
                            <td>{{ $claim->title }} <div class="mt-1 text-xs text-slate-500">{{ str($claim->category)->replace('_', ' ')->title() }}</div></td>
                            <td>{{ $claim->currency }} {{ number_format((float) $claim->amount, 2) }}</td>
                            <td>{{ $claim->expense_date?->format('d M Y') }}</td>
                            <td><span class="status-badge">{{ str($claim->status)->replace('_', ' ')->title() }}</span></td>
                            <td class="text-right"><button type="button" class="btn-dark px-4 py-2 text-xs" @click="activeEdit = {{ $claim->id }}">Edit</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div x-show="createOpen" x-cloak class="dashboard-modal-backdrop" @click.self="createOpen = false">
            <div class="dashboard-modal-card">
                <div class="flex items-center justify-between gap-4">
                    <div class="panel-title">Add Expense Claim</div>
                    <button type="button" class="btn-dark px-4 py-2 text-xs" @click="createOpen = false">Close</button>
                </div>
                <form method="POST" action="{{ route('admin.hrm.expenses.store') }}" class="mt-6 grid gap-4 md:grid-cols-2">
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
                    <input class="input" name="title" placeholder="Internet reimbursement" required>
                    <input class="input" name="category" placeholder="Utilities" required>
                    <input class="input" type="number" step="0.01" min="0" name="amount" placeholder="Amount" required>
                    <input class="input" name="currency" value="INR" required>
                    <input class="input" type="date" name="expense_date" required>
                    <select class="input" name="status">
                        @foreach (['pending', 'approved', 'reimbursed', 'rejected'] as $status)
                            <option value="{{ $status }}">{{ str($status)->replace('_', ' ')->title() }}</option>
                        @endforeach
                    </select>
                    <textarea class="input min-h-28 md:col-span-2" name="notes" placeholder="Notes"></textarea>
                    <div class="md:col-span-2 flex gap-3">
                        <button class="btn-primary">Save Claim</button>
                        <button type="button" class="btn-dark" @click="createOpen = false">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        @foreach ($claims as $claim)
            <div x-show="activeEdit === {{ $claim->id }}" x-cloak class="dashboard-modal-backdrop" @click.self="activeEdit = null">
                <div class="dashboard-modal-card">
                    <div class="flex items-center justify-between gap-4">
                        <div class="panel-title">Edit Expense Claim</div>
                        <button type="button" class="btn-dark px-4 py-2 text-xs" @click="activeEdit = null">Close</button>
                    </div>
                    <form method="POST" action="{{ route('admin.hrm.expenses.update', $claim) }}" class="mt-6 grid gap-4 md:grid-cols-2">
                        @csrf
                        @method('PATCH')
                        <input class="input" name="title" value="{{ $claim->title }}" required>
                        <input class="input" name="category" value="{{ $claim->category }}" required>
                        <input class="input" type="number" step="0.01" min="0" name="amount" value="{{ $claim->amount }}" required>
                        <input class="input" name="currency" value="{{ $claim->currency }}" required>
                        <input class="input" type="date" name="expense_date" value="{{ optional($claim->expense_date)->format('Y-m-d') }}" required>
                        <select class="input" name="status">
                            @foreach (['pending', 'approved', 'reimbursed', 'rejected'] as $status)
                                <option value="{{ $status }}" @selected($claim->status === $status)>{{ str($status)->replace('_', ' ')->title() }}</option>
                            @endforeach
                        </select>
                        <textarea class="input min-h-28 md:col-span-2" name="notes">{{ $claim->notes }}</textarea>
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
