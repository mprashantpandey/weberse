@extends('layouts.dashboard', [
    'title' => $mode === 'create' ? 'Create Job Opening' : 'Edit Job Opening',
    'heading' => $mode === 'create' ? 'Create Job Opening' : 'Edit Job Opening',
    'subheading' => 'Manage the full hiring configuration for a role.',
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

    @if (session('status'))
        <div class="card mb-6 border border-green-200 bg-green-50 text-green-700">{{ session('status') }}</div>
    @endif

    <div class="card">
        <div class="panel-title">{{ $mode === 'create' ? 'New Opening' : 'Manage Opening' }}</div>
        <div class="panel-subtitle">Role details, compensation, screening setup, and public visibility.</div>

        <form method="POST" action="{{ $mode === 'create' ? route('admin.hrm.jobs.store') : route('admin.hrm.jobs.update', $job) }}" class="mt-6 grid gap-4 md:grid-cols-2">
            @csrf
            @if($mode === 'edit')
                @method('PATCH')
            @endif
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Job title</span>
                <input class="input mt-2" name="title" value="{{ old('title', $job->title) }}" required>
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Department</span>
                <select class="input mt-2" name="department_id">
                    <option value="">General</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" @selected(old('department_id', $job->department_id) == $department->id)>{{ $department->name }}</option>
                    @endforeach
                </select>
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Location</span>
                <input class="input mt-2" name="location" value="{{ old('location', $job->location) }}">
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Employment type</span>
                <select class="input mt-2" name="employment_type">
                    @foreach (['full_time' => 'Full Time', 'part_time' => 'Part Time', 'contract' => 'Contract', 'internship' => 'Internship'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('employment_type', $job->employment_type) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Salary min</span>
                <input class="input mt-2" type="number" name="salary_min" value="{{ old('salary_min', $job->salary_min) }}">
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Salary max</span>
                <input class="input mt-2" type="number" name="salary_max" value="{{ old('salary_max', $job->salary_max) }}">
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Currency</span>
                <input class="input mt-2" name="salary_currency" value="{{ old('salary_currency', $job->salary_currency) }}">
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Notice period</span>
                <input class="input mt-2" name="notice_period" value="{{ old('notice_period', $job->notice_period) }}">
            </label>
            <div class="grid grid-cols-2 gap-4">
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Experience min</span>
                    <input class="input mt-2" type="number" name="experience_min" value="{{ old('experience_min', $job->experience_min) }}">
                </label>
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Experience max</span>
                    <input class="input mt-2" type="number" name="experience_max" value="{{ old('experience_max', $job->experience_max) }}">
                </label>
            </div>
            <div class="space-y-3">
                <label class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700">
                    <input type="checkbox" name="immediate_joiner_preferred" value="1" @checked(old('immediate_joiner_preferred', $job->immediate_joiner_preferred))>
                    Immediate joiner preferred
                </label>
                <label class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $job->is_published))>
                    Publish this role
                </label>
            </div>
            <label class="block md:col-span-2">
                <span class="text-sm font-medium text-slate-700">Description</span>
                <textarea class="input mt-2 min-h-28" name="description">{{ old('description', $job->description) }}</textarea>
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Skills required</span>
                <textarea class="input mt-2 min-h-32" name="skills">{{ old('skills', implode("\n", $job->skills ?? [])) }}</textarea>
            </label>
            <label class="block">
                <span class="text-sm font-medium text-slate-700">Application questions</span>
                <textarea class="input mt-2 min-h-32" name="application_questions">{{ old('application_questions', implode("\n", $job->application_questions ?? [])) }}</textarea>
            </label>
            <div class="md:col-span-2 flex gap-3">
                <button class="btn-primary">{{ $mode === 'create' ? 'Create Job Opening' : 'Save Changes' }}</button>
                <a href="{{ route('admin.hrm.jobs.index') }}" class="btn-dark">Back to Jobs</a>
            </div>
        </form>
    </div>
@endsection
