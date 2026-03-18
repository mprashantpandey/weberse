@extends('layouts.dashboard', [
    'title' => 'Compensation',
    'heading' => 'Compensation',
    'subheading' => 'Salary and pay records available to your account.',
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
    <div class="card overflow-x-auto">
        <div class="panel-title">Compensation Records</div>
        <table class="dashboard-table mt-6">
            <thead>
                <tr><th>Title</th><th>Type</th><th>Amount</th><th>Effective From</th><th>Status</th></tr>
            </thead>
            <tbody>
                @forelse ($records as $record)
                    <tr>
                        <td>{{ $record->title }}</td>
                        <td>{{ str($record->pay_type)->replace('_', ' ')->title() }}</td>
                        <td>{{ $record->currency }} {{ $record->amount }}</td>
                        <td>{{ $record->effective_from->format('d M Y') }}</td>
                        <td><span class="status-badge">{{ str($record->status)->title() }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-sm text-slate-500">No compensation records available yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
