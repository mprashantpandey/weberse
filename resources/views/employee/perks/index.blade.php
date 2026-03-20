@extends('layouts.dashboard', [
    'title' => 'Perks',
    'heading' => 'Perks & Benefits',
    'subheading' => 'Benefits assigned to your employee profile.',
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
    <div class="grid gap-6 md:grid-cols-2">
        @forelse ($perks as $perk)
            <div class="card">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="text-xl font-semibold text-brand-blue">{{ $perk->title }}</div>
                        <div class="mt-2 text-sm text-slate-500">{{ str($perk->perk_type)->replace('_', ' ')->title() }}</div>
                    </div>
                    <span class="status-badge">{{ str($perk->status)->replace('_', ' ')->title() }}</span>
                </div>
                <div class="mt-5 grid gap-3">
                    <div class="info-pair"><div class="info-label">Value</div><div class="info-value">{{ $perk->value ?: 'Not specified' }}</div></div>
                    <div class="info-pair"><div class="info-label">Active Window</div><div class="info-value">{{ optional($perk->starts_on)->format('d M Y') ?: '-' }} → {{ optional($perk->ends_on)->format('d M Y') ?: 'Open-ended' }}</div></div>
                    <div class="info-pair"><div class="info-label">Approved By</div><div class="info-value">{{ $perk->approver?->name ?: 'Pending approval' }}</div></div>
                    <div class="info-pair"><div class="info-label">Approval Note</div><div class="info-value">{{ $perk->review_note ?: 'No approval note yet' }}</div></div>
                    <div class="info-pair"><div class="info-label">Notes</div><div class="info-value">{{ $perk->notes ?: 'No additional notes' }}</div></div>
                </div>
            </div>
        @empty
            <div class="card text-sm text-slate-500">No perks assigned yet.</div>
        @endforelse
    </div>
@endsection
