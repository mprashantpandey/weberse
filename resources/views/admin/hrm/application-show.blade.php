@extends('layouts.dashboard', [
    'title' => 'Review Application',
    'heading' => 'Review Application',
    'subheading' => 'Full candidate review with answer context and HR actions.',
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
        <a href="{{ route('admin.hrm.jobs.index') }}" class="dashboard-subnav-link">Jobs</a>
        <a href="{{ route('admin.hrm.applications.index') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Applications</a>
        <a href="{{ route('admin.hrm.interviews.index') }}" class="dashboard-subnav-link">Interviews</a>
        <a href="{{ route('admin.hrm.compensation.index') }}" class="dashboard-subnav-link">Compensation</a>
        <a href="{{ route('admin.hrm.expenses.index') }}" class="dashboard-subnav-link">Expenses</a>
        <a href="{{ route('admin.hrm.perks.index') }}" class="dashboard-subnav-link">Perks</a>
    </div>

    @if (session('status'))
        <div class="card mb-6 border border-green-200 bg-green-50 text-green-700">{{ session('status') }}</div>
    @endif

    <div class="section-grid xl:grid-cols-[1.05fr_0.95fr]">
        <div class="card">
            <div class="panel-title">{{ $application->name }}</div>
            <div class="panel-subtitle">{{ $application->email }} @if($application->phone) • {{ $application->phone }} @endif</div>

            <div class="mt-6 grid gap-4 md:grid-cols-3">
                <div class="info-pair"><div class="info-label">Role</div><div class="info-value">{{ $application->jobOpening?->title }}</div></div>
                <div class="info-pair"><div class="info-label">Department</div><div class="info-value">{{ $application->jobOpening?->department?->name ?? 'General' }}</div></div>
                <div class="info-pair"><div class="info-label">Notice Period</div><div class="info-value">{{ $application->notice_period_response ?: 'Not provided' }}</div></div>
            </div>

            @if ($application->cover_letter)
                <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50/90 px-4 py-4">
                    <div class="info-label">Candidate Note</div>
                    <div class="mt-3 text-sm text-slate-700">{{ $application->cover_letter }}</div>
                </div>
            @endif

            @if ($application->application_answers)
                <div class="mt-6 space-y-4">
                    @foreach($application->application_answers as $question => $answer)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50/90 px-4 py-4">
                            <div class="text-sm font-semibold text-brand-blue">{{ $question }}</div>
                            <div class="mt-2 text-sm text-slate-700">{{ $answer }}</div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="mt-6">
                <div class="panel-title">Interview Timeline</div>
                <div class="panel-subtitle">Track interview rounds and candidate progress for this application.</div>
                <div class="mt-4 space-y-3">
                    @forelse ($application->interviews as $interview)
                        <div class="dashboard-item">
                            <div>
                                <div class="font-semibold text-slate-800">{{ str($interview->stage)->replace('_', ' ')->title() }} • {{ $interview->interviewer_name }}</div>
                                <div class="mt-1 text-slate-500">{{ $interview->scheduled_for?->format('d M Y, h:i A') }} • {{ str($interview->mode)->replace('_', ' ')->title() }}</div>
                            </div>
                            <div class="status-badge">{{ str($interview->status)->replace('_', ' ')->title() }}</div>
                        </div>
                    @empty
                        <div class="dashboard-item-soft text-sm text-slate-500">No interviews scheduled yet.</div>
                    @endforelse
                </div>
                <div class="mt-5">
                    <a href="{{ route('admin.hrm.interviews.index') }}" class="btn-dark">Open Interview Manager</a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="panel-title">HR Actions</div>
            <form method="POST" action="{{ route('admin.hrm.applications.update', $application) }}" class="mt-6 grid gap-4">
                @csrf
                @method('PATCH')
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Application status</span>
                    <select class="input mt-2" name="status">
                        @foreach (['applied', 'screening', 'shortlisted', 'rejected', 'hired'] as $status)
                            <option value="{{ $status }}" @selected($application->status === $status)>{{ str($status)->replace('_', ' ')->title() }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Interview status</span>
                    <select class="input mt-2" name="interview_status">
                        @foreach (['not_scheduled', 'scheduled', 'completed'] as $status)
                            <option value="{{ $status }}" @selected($application->interview_status === $status)>{{ str($status)->replace('_', ' ')->title() }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Internal notes</span>
                    <textarea class="input mt-2 min-h-40" name="notes">{{ $application->notes }}</textarea>
                </label>
                <div class="flex gap-3">
                    <button class="btn-primary">Update Application</button>
                    <a href="{{ route('admin.hrm.applications.index') }}" class="btn-dark">Back to Applications</a>
                </div>
            </form>
        </div>
    </div>
@endsection
