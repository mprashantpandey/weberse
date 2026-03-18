@extends('layouts.dashboard', [
    'title' => 'Expenses',
    'heading' => 'Expense Claims',
    'subheading' => 'Submit expenses and track reimbursement status.',
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
            <div class="panel-title">Expense History</div>
            <table class="dashboard-table mt-6">
                <thead>
                    <tr><th>Title</th><th>Category</th><th>Amount</th><th>Date</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse ($expenses as $expense)
                        <tr>
                            <td>{{ $expense->title }}</td>
                            <td>{{ str($expense->category)->replace('_', ' ')->title() }}</td>
                            <td>{{ $expense->currency }} {{ $expense->amount }}</td>
                            <td>{{ $expense->expense_date->format('d M Y') }}</td>
                            <td><span class="status-badge">{{ str($expense->status)->title() }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-sm text-slate-500">No expense claims yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card">
            <div class="panel-title">Submit Expense</div>
            <form method="POST" action="{{ route('employee.expenses.store') }}" enctype="multipart/form-data" class="mt-6 space-y-4">
                @csrf
                <input class="input" name="title" placeholder="Expense title" required>
                <input class="input" name="category" placeholder="Category" required>
                <div class="grid gap-4 md:grid-cols-2">
                    <input class="input" name="amount" type="number" step="0.01" min="0" placeholder="Amount" required>
                    <input class="input" name="currency" value="INR" required>
                </div>
                <input class="input" type="date" name="expense_date" required>
                <input class="input" type="file" name="receipt">
                <textarea class="input min-h-28" name="notes" placeholder="Notes"></textarea>
                <button class="btn-primary">Submit Expense</button>
            </form>
        </div>
    </div>
@endsection
