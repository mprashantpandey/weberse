@extends('layouts.dashboard', [
    'title' => 'HRM',
    'heading' => 'HRM Overview',
    'subheading' => 'Hiring operations and employee visibility.',
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
        <a href="{{ route('admin.hrm.index') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Overview</a>
        <a href="{{ route('admin.hrm.approvals.index') }}" class="dashboard-subnav-link">Approvals</a>
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
            <div class="metric-label">Open Roles</div>
            <div class="metric-value">{{ $summary['open_roles'] }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Applications</div>
            <div class="metric-value">{{ $summary['applications'] }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Screening</div>
            <div class="metric-value">{{ $summary['screening'] }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Employees</div>
            <div class="metric-value">{{ $summary['employees'] }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Pending Leaves</div>
            <div class="metric-value">{{ $summary['pending_leaves'] }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Pending Expenses</div>
            <div class="metric-value">{{ $summary['pending_expenses'] }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Pending Compensation</div>
            <div class="metric-value">{{ $summary['pending_compensation'] }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Pending Perks</div>
            <div class="metric-value">{{ $summary['pending_perks'] }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Today's Attendance</div>
            <div class="metric-value">{{ $summary['today_attendance'] }}</div>
        </div>
    </div>

    <div class="section-grid mt-6 xl:grid-cols-[1.05fr_0.95fr]">
        <div class="card">
            <div class="panel-title">Recent Openings</div>
            <div class="panel-subtitle">Latest published or draft roles in the hiring pipeline.</div>
            <div class="dashboard-list">
                @foreach ($jobs as $job)
                    <div class="dashboard-item">
                        <div>
                            <div class="font-semibold text-slate-800">{{ $job->title }}</div>
                            <div class="mt-1 text-slate-500">{{ $job->department?->name ?? 'General' }} • {{ $job->location ?? 'Remote' }}</div>
                        </div>
                        <div class="status-badge">{{ $job->is_published ? 'Published' : 'Draft' }}</div>
                    </div>
                @endforeach
            </div>
            <div class="mt-5">
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.hrm.jobs.index') }}" class="btn-dark">Manage Job Openings</a>
                    <a href="{{ route('admin.hrm.approvals.index') }}" class="btn-primary">Review Approvals</a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="panel-title">Recent Applications</div>
            <div class="panel-subtitle">Newest candidate submissions and their current status.</div>
            <div class="dashboard-list">
                @foreach ($applications as $application)
                    <div class="dashboard-item">
                        <div>
                            <div class="font-semibold text-slate-800">{{ $application->name }}</div>
                            <div class="mt-1 text-slate-500">{{ $application->jobOpening?->title }}</div>
                        </div>
                        <div class="status-badge">{{ str($application->status)->replace('_', ' ')->title() }}</div>
                    </div>
                @endforeach
            </div>
            <div class="mt-5">
                <a href="{{ route('admin.hrm.applications.index') }}" class="btn-dark">Review Applications</a>
            </div>
        </div>
    </div>

    <div class="card mt-6">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="panel-title">Interview Pipeline</div>
                <div class="panel-subtitle">Upcoming and recently completed interview events.</div>
            </div>
            <a href="{{ route('admin.hrm.interviews.index') }}" class="btn-dark">Manage Interviews</a>
        </div>
        <div class="mt-6 overflow-x-auto">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Candidate</th>
                        <th>Role</th>
                        <th>Stage</th>
                        <th>When</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($interviews as $interview)
                        <tr>
                            <td>{{ $interview->application?->name }}</td>
                            <td>{{ $interview->application?->jobOpening?->title }}</td>
                            <td>{{ str($interview->stage)->replace('_', ' ')->title() }}</td>
                            <td>{{ $interview->scheduled_for?->format('d M Y, h:i A') }}</td>
                            <td><span class="status-badge">{{ str($interview->status)->replace('_', ' ')->title() }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mt-6">
        <div class="panel-title">Employee Directory</div>
        <div class="panel-subtitle">Latest employee profiles and department mapping.</div>
        <div class="dashboard-list">
            @foreach($employees as $employee)
                <div class="dashboard-item">
                    <div>
                        <div class="font-semibold text-slate-800">{{ $employee->user?->name }}</div>
                        <div class="mt-1 text-slate-500">{{ $employee->department?->name }}</div>
                    </div>
                    <div class="status-badge">{{ str($employee->employment_status)->title() }}</div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
