@extends('layouts.dashboard', [
    'title' => 'HRM Jobs',
    'heading' => 'Job Openings',
    'subheading' => 'Structured role listings with cleaner management.',
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
        <a href="{{ route('admin.hrm.jobs.index') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Jobs</a>
        <a href="{{ route('admin.hrm.applications.index') }}" class="dashboard-subnav-link">Applications</a>
        <a href="{{ route('admin.hrm.interviews.index') }}" class="dashboard-subnav-link">Interviews</a>
        <a href="{{ route('admin.hrm.compensation.index') }}" class="dashboard-subnav-link">Compensation</a>
        <a href="{{ route('admin.hrm.expenses.index') }}" class="dashboard-subnav-link">Expenses</a>
        <a href="{{ route('admin.hrm.perks.index') }}" class="dashboard-subnav-link">Perks</a>
    </div>

    <div class="card">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="panel-title">All Job Openings</div>
                <div class="panel-subtitle">Use the create page for new roles. Use the edit page for full role management.</div>
            </div>
            <a href="{{ route('admin.hrm.jobs.create') }}" class="btn-primary">Create Opening</a>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Department</th>
                        <th>Type</th>
                        <th>Location</th>
                        <th>Experience</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jobs as $job)
                        <tr>
                            <td>
                                <div class="font-semibold text-slate-800">{{ $job->title }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ $job->salary_currency ?: 'INR' }} {{ $job->salary_min ? number_format((int) $job->salary_min) : '0' }}{{ $job->salary_max ? ' - '.number_format((int) $job->salary_max) : '' }}</div>
                            </td>
                            <td>{{ $job->department?->name ?? 'General' }}</td>
                            <td>{{ str($job->employment_type)->replace('_', ' ')->title() }}</td>
                            <td>{{ $job->location ?? 'Remote' }}</td>
                            <td>
                                @if($job->experience_min !== null || $job->experience_max !== null)
                                    {{ $job->experience_min ?? 0 }}-{{ $job->experience_max ?? $job->experience_min }} yrs
                                @else
                                    —
                                @endif
                            </td>
                            <td><span class="status-badge">{{ $job->is_published ? 'Published' : 'Draft' }}</span></td>
                            <td class="text-right">
                                <a href="{{ route('admin.hrm.jobs.edit', $job) }}" class="btn-dark px-4 py-2 text-xs">Manage</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
