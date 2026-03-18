@extends('layouts.dashboard', [
    'title' => 'Employee Profile',
    'heading' => 'Employee Profile',
    'subheading' => 'Personal and employment information linked to your staff account.',
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
    @if (session('status'))
        <div class="card mb-6 border border-green-200 bg-green-50 text-green-700">{{ session('status') }}</div>
    @endif
    <div class="grid gap-6 xl:grid-cols-[1fr_0.9fr]">
        <div class="card">
            <div class="panel-title">Personal Details</div>
            <form method="POST" action="{{ route('employee.profile.update') }}" class="mt-6 grid gap-4 md:grid-cols-2">
                @csrf
                @method('PATCH')
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Name</span>
                    <input class="input mt-2" name="name" value="{{ old('name', $user->name) }}" required>
                </label>
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Email</span>
                    <input class="input mt-2 bg-slate-50" value="{{ $user->email }}" disabled>
                </label>
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Phone</span>
                    <input class="input mt-2" name="phone" value="{{ old('phone', $user->phone) }}">
                </label>
                <label class="block">
                    <span class="text-sm font-medium text-slate-700">Job Title</span>
                    <input class="input mt-2" name="job_title" value="{{ old('job_title', $user->job_title) }}">
                </label>
                <label class="block md:col-span-2">
                    <span class="text-sm font-medium text-slate-700">Emergency Contact</span>
                    <input class="input mt-2" name="emergency_contact" value="{{ old('emergency_contact', $profile?->emergency_contact) }}">
                </label>
                <div class="md:col-span-2">
                    <button class="btn-primary">Save Profile</button>
                </div>
            </form>
        </div>
        <div class="card">
            <div class="panel-title">Employment Snapshot</div>
            <div class="mt-6 grid gap-4">
                <div class="info-pair"><div class="info-label">Employee Code</div><div class="info-value">{{ $profile?->employee_code ?: 'Not assigned' }}</div></div>
                <div class="info-pair"><div class="info-label">Department</div><div class="info-value">{{ $profile?->department?->name ?? 'General' }}</div></div>
                <div class="info-pair"><div class="info-label">Join Date</div><div class="info-value">{{ optional($profile?->join_date)->format('d M Y') ?: 'Not set' }}</div></div>
                <div class="info-pair"><div class="info-label">Status</div><div class="info-value">{{ $profile ? str($profile->employment_status)->title() : 'No profile' }}</div></div>
                <div class="info-pair"><div class="info-label">Stored Documents</div><div class="info-value">{{ is_array($profile?->documents) ? count($profile->documents) : 0 }}</div></div>
            </div>
        </div>
    </div>
@endsection
