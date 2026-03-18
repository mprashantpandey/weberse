@extends('layouts.dashboard', [
    'title' => 'HRM Interviews',
    'heading' => 'Interview Schedules',
    'subheading' => 'Schedule interviews, send invites, and close rounds without bloating the application screen.',
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
        <a href="{{ route('admin.hrm.interviews.index') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Interviews</a>
        <a href="{{ route('admin.hrm.compensation.index') }}" class="dashboard-subnav-link">Compensation</a>
        <a href="{{ route('admin.hrm.expenses.index') }}" class="dashboard-subnav-link">Expenses</a>
        <a href="{{ route('admin.hrm.perks.index') }}" class="dashboard-subnav-link">Perks</a>
    </div>

    <div class="card card-modal-host" x-data="{ createOpen: false, activeEdit: null }">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="panel-title">Interview Manager</div>
                <div class="panel-subtitle">Create interview rounds and send candidate + internal email notifications automatically.</div>
            </div>
            <button type="button" class="btn-primary" @click="createOpen = true">Schedule Interview</button>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Candidate</th>
                        <th>Role</th>
                        <th>Interviewer</th>
                        <th>Stage</th>
                        <th>When</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($interviews as $interview)
                        <tr>
                            <td>{{ $interview->application?->name }}</td>
                            <td>{{ $interview->application?->jobOpening?->title }}</td>
                            <td>{{ $interview->interviewer_name }}</td>
                            <td>{{ str($interview->stage)->replace('_', ' ')->title() }}</td>
                            <td>{{ $interview->scheduled_for?->format('d M Y, h:i A') }}</td>
                            <td><span class="status-badge">{{ str($interview->status)->replace('_', ' ')->title() }}</span></td>
                            <td class="text-right">
                                <button type="button" class="btn-dark px-4 py-2 text-xs" @click="activeEdit = {{ $interview->id }}">Update</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div x-show="createOpen" x-cloak class="dashboard-modal-backdrop" @click.self="createOpen = false">
            <div class="dashboard-modal-card">
                <div class="flex items-center justify-between gap-4">
                    <div class="panel-title">Schedule Interview</div>
                    <button type="button" class="btn-dark px-4 py-2 text-xs" @click="createOpen = false">Close</button>
                </div>
                <form method="POST" action="{{ route('admin.hrm.interviews.store') }}" class="mt-6 grid gap-4 md:grid-cols-2">
                    @csrf
                    <label class="block md:col-span-2">
                        <span class="text-sm font-medium text-slate-700">Candidate application</span>
                        <select class="input mt-2" name="job_application_id" required>
                            <option value="">Select application</option>
                            @foreach ($applications as $application)
                                <option value="{{ $application->id }}">{{ $application->name }} • {{ $application->jobOpening?->title }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Interviewer name</span>
                        <input class="input mt-2" name="interviewer_name" required>
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Interviewer email</span>
                        <input class="input mt-2" type="email" name="interviewer_email">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Mode</span>
                        <select class="input mt-2" name="mode">
                            @foreach (['video', 'phone', 'onsite'] as $mode)
                                <option value="{{ $mode }}">{{ str($mode)->title() }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Stage</span>
                        <select class="input mt-2" name="stage">
                            @foreach (['screening', 'technical', 'final'] as $stage)
                                <option value="{{ $stage }}">{{ str($stage)->title() }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Scheduled for</span>
                        <input class="input mt-2" type="datetime-local" name="scheduled_for" required>
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium text-slate-700">Duration (minutes)</span>
                        <input class="input mt-2" type="number" name="duration_minutes" min="15" value="45" required>
                    </label>
                    <label class="block md:col-span-2">
                        <span class="text-sm font-medium text-slate-700">Meeting link</span>
                        <input class="input mt-2" name="meeting_link" placeholder="https://meet.google.com/...">
                    </label>
                    <label class="block md:col-span-2">
                        <span class="text-sm font-medium text-slate-700">Notes for the candidate</span>
                        <textarea class="input mt-2 min-h-28" name="notes"></textarea>
                    </label>
                    <input type="hidden" name="status" value="scheduled">
                    <div class="md:col-span-2 flex gap-3">
                        <button class="btn-primary">Schedule & Send Invite</button>
                        <button type="button" class="btn-dark" @click="createOpen = false">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        @foreach ($interviews as $interview)
            <div x-show="activeEdit === {{ $interview->id }}" x-cloak class="dashboard-modal-backdrop" @click.self="activeEdit = null">
                <div class="dashboard-modal-card">
                    <div class="flex items-center justify-between gap-4">
                        <div class="panel-title">Update Interview</div>
                        <button type="button" class="btn-dark px-4 py-2 text-xs" @click="activeEdit = null">Close</button>
                    </div>
                    <form method="POST" action="{{ route('admin.hrm.interviews.update', $interview) }}" class="mt-6 grid gap-4 md:grid-cols-2">
                        @csrf
                        @method('PATCH')
                        <label class="block">
                            <span class="text-sm font-medium text-slate-700">Interviewer name</span>
                            <input class="input mt-2" name="interviewer_name" value="{{ $interview->interviewer_name }}" required>
                        </label>
                        <label class="block">
                            <span class="text-sm font-medium text-slate-700">Interviewer email</span>
                            <input class="input mt-2" type="email" name="interviewer_email" value="{{ $interview->interviewer_email }}">
                        </label>
                        <label class="block">
                            <span class="text-sm font-medium text-slate-700">Mode</span>
                            <select class="input mt-2" name="mode">
                                @foreach (['video', 'phone', 'onsite'] as $mode)
                                    <option value="{{ $mode }}" @selected($interview->mode === $mode)>{{ str($mode)->title() }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block">
                            <span class="text-sm font-medium text-slate-700">Stage</span>
                            <select class="input mt-2" name="stage">
                                @foreach (['screening', 'technical', 'final'] as $stage)
                                    <option value="{{ $stage }}" @selected($interview->stage === $stage)>{{ str($stage)->title() }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block">
                            <span class="text-sm font-medium text-slate-700">Scheduled for</span>
                            <input class="input mt-2" type="datetime-local" name="scheduled_for" value="{{ optional($interview->scheduled_for)->format('Y-m-d\TH:i') }}" required>
                        </label>
                        <label class="block">
                            <span class="text-sm font-medium text-slate-700">Duration (minutes)</span>
                            <input class="input mt-2" type="number" name="duration_minutes" min="15" value="{{ $interview->duration_minutes }}" required>
                        </label>
                        <label class="block md:col-span-2">
                            <span class="text-sm font-medium text-slate-700">Meeting link</span>
                            <input class="input mt-2" name="meeting_link" value="{{ $interview->meeting_link }}">
                        </label>
                        <label class="block">
                            <span class="text-sm font-medium text-slate-700">Status</span>
                            <select class="input mt-2" name="status">
                                @foreach (['scheduled', 'completed', 'cancelled'] as $status)
                                    <option value="{{ $status }}" @selected($interview->status === $status)>{{ str($status)->title() }}</option>
                                @endforeach
                            </select>
                        </label>
                        <div></div>
                        <label class="block md:col-span-2">
                            <span class="text-sm font-medium text-slate-700">Notes</span>
                            <textarea class="input mt-2 min-h-28" name="notes">{{ $interview->notes }}</textarea>
                        </label>
                        <label class="block md:col-span-2">
                            <span class="text-sm font-medium text-slate-700">Feedback</span>
                            <textarea class="input mt-2 min-h-28" name="feedback">{{ $interview->feedback }}</textarea>
                        </label>
                        <div class="md:col-span-2 flex gap-3">
                            <button class="btn-primary">Save Interview</button>
                            <button type="button" class="btn-dark" @click="activeEdit = null">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
