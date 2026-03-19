@extends('layouts.dashboard', [
    'title' => 'HRM Applications',
    'heading' => 'Applications',
    'subheading' => 'Candidate review with a cleaner table-first workflow.',
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
        <a href="{{ route('admin.hrm.jobs.index') }}" class="dashboard-subnav-link">Jobs</a>
        <a href="{{ route('admin.hrm.applications.index') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Applications</a>
        <a href="{{ route('admin.hrm.interviews.index') }}" class="dashboard-subnav-link">Interviews</a>
        <a href="{{ route('admin.hrm.compensation.index') }}" class="dashboard-subnav-link">Compensation</a>
        <a href="{{ route('admin.hrm.expenses.index') }}" class="dashboard-subnav-link">Expenses</a>
        <a href="{{ route('admin.hrm.perks.index') }}" class="dashboard-subnav-link">Perks</a>
    </div>

    <div class="card">
        <div class="panel-title">Candidate Applications</div>
        <div class="panel-subtitle">Open an application to review full answers, resume context, and update HR status.</div>
        <div class="mt-6 overflow-x-auto">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Candidate</th>
                        <th>Role</th>
                        <th>Notice Period</th>
                        <th>Status</th>
                        <th>Interview</th>
                        <th>Schedules</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $application)
                        <tr>
                            <td>
                                <div class="font-semibold text-slate-800">{{ $application->name }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ $application->email }}</div>
                            </td>
                            <td>{{ $application->jobOpening?->title }}</td>
                            <td>{{ $application->notice_period_response ?: 'Not provided' }}</td>
                            <td><span class="status-badge">{{ str($application->status)->replace('_', ' ')->title() }}</span></td>
                            <td><span class="status-badge">{{ str($application->interview_status)->replace('_', ' ')->title() }}</span></td>
                            <td>{{ $application->interviews->count() }}</td>
                            <td class="text-right">
                                <a href="{{ route('admin.hrm.applications.show', $application) }}" class="btn-dark px-4 py-2 text-xs">Review</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
