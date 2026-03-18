@extends('layouts.dashboard', [
    'title' => 'Leave Requests',
    'heading' => 'Leave Requests',
    'subheading' => 'Request time off and track approvals.',
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
        <div class="card overflow-x-auto">
            <div class="panel-title">Leave History</div>
            <div class="panel-subtitle">All leave requests tied to your employee profile.</div>
            <table class="dashboard-table mt-6">
                <thead>
                    <tr><th>Type</th><th>Start</th><th>End</th><th>Status</th><th>Reason</th></tr>
                </thead>
                <tbody>
                    @forelse ($leaves as $leave)
                        <tr>
                            <td>{{ str($leave->type)->replace('_', ' ')->title() }}</td>
                            <td>{{ $leave->start_date->format('d M Y') }}</td>
                            <td>{{ $leave->end_date->format('d M Y') }}</td>
                            <td><span class="status-badge">{{ str($leave->status)->title() }}</span></td>
                            <td>{{ $leave->reason ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-sm text-slate-500">No leave requests yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card">
            <div class="panel-title">Request Leave</div>
            <form method="POST" action="{{ route('employee.leaves.store') }}" class="mt-6 space-y-4">
                @csrf
                <select class="input" name="type">
                    <option value="casual">Casual Leave</option>
                    <option value="sick">Sick Leave</option>
                    <option value="earned">Earned Leave</option>
                    <option value="unpaid">Unpaid Leave</option>
                </select>
                <input class="input" type="date" name="start_date" required>
                <input class="input" type="date" name="end_date" required>
                <textarea class="input min-h-28" name="reason" placeholder="Reason"></textarea>
                <button class="btn-primary">Submit Leave Request</button>
            </form>
        </div>
    </div>
@endsection
