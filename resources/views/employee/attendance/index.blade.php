@extends('layouts.dashboard', [
    'title' => 'Attendance',
    'heading' => 'Attendance',
    'subheading' => 'Check in, check out, and review your attendance history.',
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
    <div class="grid gap-6 xl:grid-cols-[0.9fr_1.1fr]">
        <div class="card">
            <div class="panel-title">Today</div>
            <div class="panel-subtitle">Use one button to check in first, then check out later.</div>
            <div class="mt-6 grid gap-4">
                <div class="info-pair"><div class="info-label">Work Date</div><div class="info-value">{{ now()->format('d M Y') }}</div></div>
                <div class="info-pair"><div class="info-label">Clock In</div><div class="info-value">{{ optional($todayAttendance?->clock_in_at)->format('h:i A') ?: 'Not recorded' }}</div></div>
                <div class="info-pair"><div class="info-label">Clock Out</div><div class="info-value">{{ optional($todayAttendance?->clock_out_at)->format('h:i A') ?: 'Not recorded' }}</div></div>
                <div class="info-pair"><div class="info-label">Status</div><div class="info-value">{{ $todayAttendance ? str($todayAttendance->status)->replace('_', ' ')->title() : 'Pending' }}</div></div>
            </div>
            <form method="POST" action="{{ route('employee.attendance.store') }}" class="mt-6">
                @csrf
                <button class="btn-primary">
                    {{ !$todayAttendance?->clock_in_at ? 'Check In' : (!$todayAttendance?->clock_out_at ? 'Check Out' : 'Attendance Completed') }}
                </button>
            </form>
        </div>
        <div class="card overflow-x-auto">
            <div class="panel-title">Attendance History</div>
            <table class="dashboard-table mt-6">
                <thead>
                    <tr><th>Date</th><th>Clock In</th><th>Clock Out</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse ($records as $record)
                        <tr>
                            <td>{{ $record->work_date->format('d M Y') }}</td>
                            <td>{{ optional($record->clock_in_at)->format('h:i A') ?: '-' }}</td>
                            <td>{{ optional($record->clock_out_at)->format('h:i A') ?: '-' }}</td>
                            <td><span class="status-badge">{{ str($record->status)->replace('_', ' ')->title() }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-sm text-slate-500">No attendance records yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
