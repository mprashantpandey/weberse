@extends('layouts.dashboard', [
    'title' => 'Leave Approvals',
    'heading' => 'Leave Approvals',
    'subheading' => 'Review employee leave requests and approve or reject them.',
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
        <a href="{{ route('admin.hrm.employees.index') }}" class="dashboard-subnav-link">Employees</a>
        <a href="{{ route('admin.hrm.leaves.index') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Leaves</a>
        <a href="{{ route('admin.hrm.jobs.index') }}" class="dashboard-subnav-link">Jobs</a>
        <a href="{{ route('admin.hrm.applications.index') }}" class="dashboard-subnav-link">Applications</a>
        <a href="{{ route('admin.hrm.interviews.index') }}" class="dashboard-subnav-link">Interviews</a>
        <a href="{{ route('admin.hrm.attendance.index') }}" class="dashboard-subnav-link">Attendance</a>
        <a href="{{ route('admin.hrm.compensation.index') }}" class="dashboard-subnav-link">Compensation</a>
        <a href="{{ route('admin.hrm.expenses.index') }}" class="dashboard-subnav-link">Expenses</a>
        <a href="{{ route('admin.hrm.perks.index') }}" class="dashboard-subnav-link">Perks</a>
    </div>

    <div class="card mt-6 overflow-x-auto">
        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Department</th>
                    <th>Type</th>
                    <th>Dates</th>
                    <th>Status</th>
                    <th>Reviewed By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($leaves as $leave)
                    <tr>
                        <td>{{ $leave->employeeProfile?->user?->name }}</td>
                        <td>{{ $leave->employeeProfile?->department?->name ?? 'General' }}</td>
                        <td>{{ str($leave->type)->replace('_', ' ')->title() }}</td>
                        <td>{{ $leave->start_date->format('d M Y') }} → {{ $leave->end_date->format('d M Y') }}</td>
                        <td><span class="status-badge">{{ str($leave->status)->title() }}</span></td>
                        <td>{{ $leave->reviewer?->name ?: '-' }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.hrm.leaves.update', $leave) }}" class="flex flex-wrap items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <select class="input !py-2 !px-3 !text-xs" name="status">
                                    @foreach (['pending', 'approved', 'rejected'] as $status)
                                        <option value="{{ $status }}" @selected($leave->status === $status)>{{ str($status)->title() }}</option>
                                    @endforeach
                                </select>
                                <input class="input !py-2 !px-3 !text-xs" name="reason" value="{{ $leave->reason }}" placeholder="Reason / note">
                                <button class="btn-dark !px-4 !py-2 text-xs">Save</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-sm text-slate-500">No leave requests found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
