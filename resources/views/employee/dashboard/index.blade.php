@extends('layouts.dashboard', [
    'title' => 'Employee Workspace',
    'heading' => 'Employee Workspace',
    'subheading' => 'Your leave, expenses, compensation, perks, and profile in one place.',
    'nav' => [
        ['label' => 'Overview', 'route' => 'employee.dashboard', 'active' => 'employee.dashboard'],
        ['label' => 'Attendance', 'route' => 'employee.attendance.index', 'active' => 'employee.attendance.*'],
        ['label' => 'Leave', 'route' => 'employee.leaves.index', 'active' => 'employee.leaves.*'],
        ['label' => 'Expenses', 'route' => 'employee.expenses.index', 'active' => 'employee.expenses.*'],
        ['label' => 'Compensation', 'route' => 'employee.compensation.index', 'active' => 'employee.compensation.*'],
        ['label' => 'Perks', 'route' => 'employee.perks.index', 'active' => 'employee.perks.*'],
        ['label' => 'Profile', 'route' => 'employee.profile.index', 'active' => 'employee.profile.*'],
    ],
])

@section('content')
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <div class="metric-card"><div class="metric-label">Pending Leaves</div><div class="metric-value">{{ $summary['pending_leaves'] }}</div></div>
        <div class="metric-card"><div class="metric-label">Pending Expenses</div><div class="metric-value">{{ $summary['pending_expenses'] }}</div></div>
        <div class="metric-card"><div class="metric-label">Active Perks</div><div class="metric-value">{{ $summary['active_perks'] }}</div></div>
        <div class="metric-card"><div class="metric-label">Comp Records</div><div class="metric-value">{{ $summary['active_compensation'] }}</div></div>
    </div>

    <div class="grid gap-6 mt-6 xl:grid-cols-[1fr_1fr]">
        <div class="card">
            <div class="panel-title">Employment Snapshot</div>
            <div class="panel-subtitle">Current employee details on file.</div>
            @if ($profile)
                <div class="mt-6 grid gap-4 md:grid-cols-2">
                    <div class="info-pair"><div class="info-label">Employee Code</div><div class="info-value">{{ $profile->employee_code }}</div></div>
                    <div class="info-pair"><div class="info-label">Department</div><div class="info-value">{{ $profile->department?->name ?? 'General' }}</div></div>
                    <div class="info-pair"><div class="info-label">Join Date</div><div class="info-value">{{ optional($profile->join_date)->format('d M Y') ?: 'Not set' }}</div></div>
                    <div class="info-pair"><div class="info-label">Status</div><div class="info-value">{{ str($profile->employment_status)->title() }}</div></div>
                </div>
            @else
                <div class="dashboard-item-soft mt-6 text-sm text-slate-500">No employee profile is linked to this account yet.</div>
            @endif
        </div>
        <div class="card">
            <div class="panel-title">Quick Links</div>
            <div class="panel-subtitle">Most-used actions in the employee workspace.</div>
            <div class="mt-6 grid gap-3 sm:grid-cols-2">
                <a href="{{ route('employee.attendance.index') }}" class="dashboard-item-soft block text-sm font-medium text-brand-blue">Attendance</a>
                <a href="{{ route('employee.leaves.index') }}" class="dashboard-item-soft block text-sm font-medium text-brand-blue">Request Leave</a>
                <a href="{{ route('employee.expenses.index') }}" class="dashboard-item-soft block text-sm font-medium text-brand-blue">Submit Expense</a>
                <a href="{{ route('employee.compensation.index') }}" class="dashboard-item-soft block text-sm font-medium text-brand-blue">View Compensation</a>
                <a href="{{ route('employee.profile.index') }}" class="dashboard-item-soft block text-sm font-medium text-brand-blue">Update Profile</a>
            </div>
        </div>
    </div>

    <div class="grid gap-6 mt-6 xl:grid-cols-[1fr_1fr]">
        <div class="card">
            <div class="panel-title">Recent Leave Requests</div>
            <div class="dashboard-list mt-6">
                @forelse ($recentLeaves as $leave)
                    <div class="dashboard-item">
                        <div>
                            <div class="font-semibold text-slate-800">{{ str($leave->type)->replace('_', ' ')->title() }}</div>
                            <div class="mt-1 text-slate-500">{{ $leave->start_date->format('d M Y') }} → {{ $leave->end_date->format('d M Y') }}</div>
                        </div>
                        <div class="status-badge">{{ str($leave->status)->title() }}</div>
                    </div>
                @empty
                    <div class="dashboard-item-soft text-sm text-slate-500">No leave activity yet.</div>
                @endforelse
            </div>
        </div>
        <div class="card">
            <div class="panel-title">Recent Expenses</div>
            <div class="dashboard-list mt-6">
                @forelse ($recentExpenses as $expense)
                    <div class="dashboard-item">
                        <div>
                            <div class="font-semibold text-slate-800">{{ $expense->title }}</div>
                            <div class="mt-1 text-slate-500">{{ $expense->currency }} {{ $expense->amount }} · {{ $expense->expense_date->format('d M Y') }}</div>
                        </div>
                        <div class="status-badge">{{ str($expense->status)->title() }}</div>
                    </div>
                @empty
                    <div class="dashboard-item-soft text-sm text-slate-500">No expense claims yet.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
