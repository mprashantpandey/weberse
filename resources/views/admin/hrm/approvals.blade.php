@extends('layouts.dashboard', [
    'title' => 'HRM Approvals',
    'heading' => 'Approvals',
    'subheading' => 'Approve leave, expenses, compensation, and perk changes from one queue.',
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
    <div class="dashboard-subnav">
        <a href="{{ route('admin.hrm.index') }}" class="dashboard-subnav-link">Overview</a>
        <a href="{{ route('admin.hrm.approvals.index') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Approvals</a>
        <a href="{{ route('admin.hrm.employees.index') }}" class="dashboard-subnav-link">Employees</a>
        <a href="{{ route('admin.hrm.leaves.index') }}" class="dashboard-subnav-link">Leaves</a>
        <a href="{{ route('admin.hrm.jobs.index') }}" class="dashboard-subnav-link">Jobs</a>
        <a href="{{ route('admin.hrm.applications.index') }}" class="dashboard-subnav-link">Applications</a>
        <a href="{{ route('admin.hrm.interviews.index') }}" class="dashboard-subnav-link">Interviews</a>
        <a href="{{ route('admin.hrm.attendance.index') }}" class="dashboard-subnav-link">Attendance</a>
        <a href="{{ route('admin.hrm.compensation.index') }}" class="dashboard-subnav-link">Compensation</a>
        <a href="{{ route('admin.hrm.expenses.index') }}" class="dashboard-subnav-link">Expenses</a>
        <a href="{{ route('admin.hrm.perks.index') }}" class="dashboard-subnav-link">Perks</a>
    </div>

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <div class="metric-card">
            <div class="metric-label">Leave Requests</div>
            <div class="metric-value">{{ $pendingLeaves->count() }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Expense Claims</div>
            <div class="metric-value">{{ $pendingExpenses->count() }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Compensation Changes</div>
            <div class="metric-value">{{ $pendingCompensation->count() }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Perk Changes</div>
            <div class="metric-value">{{ $pendingPerks->count() }}</div>
        </div>
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-2">
        <div class="card">
            <div class="panel-title">Pending Leave Requests</div>
            <div class="panel-subtitle">Approve or reject time-off requests with an internal note.</div>
            <div class="dashboard-list mt-6">
                @forelse ($pendingLeaves as $leave)
                    <div class="dashboard-item block">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <div class="font-semibold text-slate-800">{{ $leave->employeeProfile?->user?->name }}</div>
                                <div class="mt-1 text-sm text-slate-500">{{ $leave->employeeProfile?->department?->name ?? 'General' }} • {{ str($leave->type)->replace('_', ' ')->title() }}</div>
                                <div class="mt-1 text-sm text-slate-500">{{ $leave->start_date?->format('d M Y') }} → {{ $leave->end_date?->format('d M Y') }}</div>
                            </div>
                            <span class="status-badge">Pending</span>
                        </div>
                        <form method="POST" action="{{ route('admin.hrm.leaves.update', $leave) }}" class="mt-4 grid gap-3 md:grid-cols-[1fr_auto_auto]">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="reason" value="{{ $leave->reason }}">
                            <input class="input" name="review_note" placeholder="Approval note or rejection reason">
                            <button class="btn-primary" name="status" value="approved">Approve</button>
                            <button class="btn-dark" name="status" value="rejected">Reject</button>
                        </form>
                    </div>
                @empty
                    <div class="text-sm text-slate-500">No leave requests awaiting approval.</div>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="panel-title">Pending Expense Claims</div>
            <div class="panel-subtitle">Review submitted expenses before approval or reimbursement.</div>
            <div class="dashboard-list mt-6">
                @forelse ($pendingExpenses as $claim)
                    <div class="dashboard-item block">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <div class="font-semibold text-slate-800">{{ $claim->employeeProfile?->user?->name }}</div>
                                <div class="mt-1 text-sm text-slate-500">{{ $claim->title }} • {{ str($claim->category)->replace('_', ' ')->title() }}</div>
                                <div class="mt-1 text-sm text-slate-500">{{ $claim->currency }} {{ number_format((float) $claim->amount, 2) }} • {{ $claim->expense_date?->format('d M Y') }}</div>
                            </div>
                            <span class="status-badge">Pending</span>
                        </div>
                        <form method="POST" action="{{ route('admin.hrm.expenses.update', $claim) }}" class="mt-4 grid gap-3 md:grid-cols-2">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="title" value="{{ $claim->title }}">
                            <input type="hidden" name="category" value="{{ $claim->category }}">
                            <input type="hidden" name="amount" value="{{ $claim->amount }}">
                            <input type="hidden" name="currency" value="{{ $claim->currency }}">
                            <input type="hidden" name="expense_date" value="{{ optional($claim->expense_date)->format('Y-m-d') }}">
                            <input type="hidden" name="notes" value="{{ $claim->notes }}">
                            <input class="input md:col-span-2" name="review_note" placeholder="Approval note or rejection reason">
                            <div class="flex flex-wrap gap-3 md:col-span-2">
                                <button class="btn-primary" name="status" value="approved">Approve</button>
                                <button class="btn-dark" name="status" value="rejected">Reject</button>
                                <button class="btn-dark" name="status" value="reimbursed">Mark Reimbursed</button>
                            </div>
                        </form>
                    </div>
                @empty
                    <div class="text-sm text-slate-500">No expense claims awaiting approval.</div>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="panel-title">Pending Compensation Changes</div>
            <div class="panel-subtitle">Salary and allowance changes stay pending until approved.</div>
            <div class="dashboard-list mt-6">
                @forelse ($pendingCompensation as $record)
                    <div class="dashboard-item block">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <div class="font-semibold text-slate-800">{{ $record->employeeProfile?->user?->name }}</div>
                                <div class="mt-1 text-sm text-slate-500">{{ $record->title }} • {{ str($record->pay_type)->replace('_', ' ')->title() }}</div>
                                <div class="mt-1 text-sm text-slate-500">{{ $record->currency }} {{ number_format((float) $record->amount, 2) }} effective {{ $record->effective_from?->format('d M Y') }}</div>
                            </div>
                            <span class="status-badge">Pending Approval</span>
                        </div>
                        <form method="POST" action="{{ route('admin.hrm.compensation.update', $record) }}" class="mt-4 grid gap-3 md:grid-cols-2">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="title" value="{{ $record->title }}">
                            <input type="hidden" name="pay_type" value="{{ $record->pay_type }}">
                            <input type="hidden" name="amount" value="{{ $record->amount }}">
                            <input type="hidden" name="currency" value="{{ $record->currency }}">
                            <input type="hidden" name="effective_from" value="{{ optional($record->effective_from)->format('Y-m-d') }}">
                            <input type="hidden" name="effective_to" value="{{ optional($record->effective_to)->format('Y-m-d') }}">
                            <input type="hidden" name="notes" value="{{ $record->notes }}">
                            <input class="input md:col-span-2" name="review_note" placeholder="Approval note or rejection reason">
                            <div class="flex flex-wrap gap-3 md:col-span-2">
                                <button class="btn-primary" name="status" value="approved">Approve</button>
                                <button class="btn-dark" name="status" value="rejected">Reject</button>
                            </div>
                        </form>
                    </div>
                @empty
                    <div class="text-sm text-slate-500">No compensation changes awaiting approval.</div>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="panel-title">Pending Perk Changes</div>
            <div class="panel-subtitle">Benefits can be staged first, then activated after approval.</div>
            <div class="dashboard-list mt-6">
                @forelse ($pendingPerks as $perk)
                    <div class="dashboard-item block">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <div class="font-semibold text-slate-800">{{ $perk->employeeProfile?->user?->name }}</div>
                                <div class="mt-1 text-sm text-slate-500">{{ $perk->title }} • {{ str($perk->perk_type)->replace('_', ' ')->title() }}</div>
                                <div class="mt-1 text-sm text-slate-500">{{ $perk->value ?: 'No value specified' }}</div>
                            </div>
                            <span class="status-badge">Pending Approval</span>
                        </div>
                        <form method="POST" action="{{ route('admin.hrm.perks.update', $perk) }}" class="mt-4 grid gap-3 md:grid-cols-2">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="title" value="{{ $perk->title }}">
                            <input type="hidden" name="perk_type" value="{{ $perk->perk_type }}">
                            <input type="hidden" name="value" value="{{ $perk->value }}">
                            <input type="hidden" name="starts_on" value="{{ optional($perk->starts_on)->format('Y-m-d') }}">
                            <input type="hidden" name="ends_on" value="{{ optional($perk->ends_on)->format('Y-m-d') }}">
                            <input type="hidden" name="notes" value="{{ $perk->notes }}">
                            <input class="input md:col-span-2" name="review_note" placeholder="Approval note or rejection reason">
                            <div class="flex flex-wrap gap-3 md:col-span-2">
                                <button class="btn-primary" name="status" value="active">Approve & Activate</button>
                                <button class="btn-dark" name="status" value="rejected">Reject</button>
                            </div>
                        </form>
                    </div>
                @empty
                    <div class="text-sm text-slate-500">No perk changes awaiting approval.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
