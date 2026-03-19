@extends('layouts.dashboard', [
    'title' => 'Attendance',
    'heading' => 'Attendance',
    'subheading' => 'Daily attendance visibility and manual corrections.',
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
        <a href="{{ route('admin.hrm.approvals.index') }}" class="dashboard-subnav-link">Approvals</a>
        <a href="{{ route('admin.hrm.employees.index') }}" class="dashboard-subnav-link">Employees</a>
        <a href="{{ route('admin.hrm.leaves.index') }}" class="dashboard-subnav-link">Leaves</a>
        <a href="{{ route('admin.hrm.jobs.index') }}" class="dashboard-subnav-link">Jobs</a>
        <a href="{{ route('admin.hrm.applications.index') }}" class="dashboard-subnav-link">Applications</a>
        <a href="{{ route('admin.hrm.interviews.index') }}" class="dashboard-subnav-link">Interviews</a>
        <a href="{{ route('admin.hrm.attendance.index') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Attendance</a>
        <a href="{{ route('admin.hrm.compensation.index') }}" class="dashboard-subnav-link">Compensation</a>
        <a href="{{ route('admin.hrm.expenses.index') }}" class="dashboard-subnav-link">Expenses</a>
        <a href="{{ route('admin.hrm.perks.index') }}" class="dashboard-subnav-link">Perks</a>
    </div>

    <div class="grid gap-6 mt-6 xl:grid-cols-[1fr_0.9fr]">
        <div class="card overflow-x-auto">
            <div class="panel-title">Attendance Records</div>
            <table class="dashboard-table mt-6">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Date</th>
                        <th>Clock In</th>
                        <th>Clock Out</th>
                        <th>Status</th>
                        <th>Marked By</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($records as $record)
                        <tr>
                            <td>{{ $record->employeeProfile?->user?->name }}</td>
                            <td>{{ $record->work_date->format('d M Y') }}</td>
                            <td>{{ optional($record->clock_in_at)->format('h:i A') ?: '-' }}</td>
                            <td>{{ optional($record->clock_out_at)->format('h:i A') ?: '-' }}</td>
                            <td><span class="status-badge">{{ str($record->status)->replace('_', ' ')->title() }}</span></td>
                            <td>{{ $record->marker?->name ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-sm text-slate-500">No attendance records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card">
            <div class="panel-title">Add / Correct Attendance</div>
            <form method="POST" action="{{ route('admin.hrm.attendance.store') }}" class="mt-6 space-y-4">
                @csrf
                <select class="input" name="employee_profile_id" required>
                    <option value="">Select employee</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->user?->name }} · {{ $employee->employee_code }}</option>
                    @endforeach
                </select>
                <input class="input" type="date" name="work_date" value="{{ now()->toDateString() }}" required>
                <input class="input" type="datetime-local" name="clock_in_at">
                <input class="input" type="datetime-local" name="clock_out_at">
                <select class="input" name="status">
                    <option value="present">Present</option>
                    <option value="half_day">Half Day</option>
                    <option value="leave">Leave</option>
                    <option value="absent">Absent</option>
                </select>
                <textarea class="input min-h-28" name="notes" placeholder="Notes"></textarea>
                <button class="btn-primary">Save Attendance</button>
            </form>
        </div>
    </div>
@endsection
