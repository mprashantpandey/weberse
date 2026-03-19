@extends('layouts.dashboard', [
    'title' => 'HRM Employees',
    'heading' => 'Employee Management',
    'subheading' => 'Directory visibility, salary context, perks, and reimbursements in one cleaner view.',
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
        <a href="{{ route('admin.hrm.approvals.index') }}" class="dashboard-subnav-link">Approvals</a>
        <a href="{{ route('admin.hrm.employees.index') }}" class="dashboard-subnav-link dashboard-subnav-link-active">Employees</a>
        <a href="{{ route('admin.hrm.jobs.index') }}" class="dashboard-subnav-link">Jobs</a>
        <a href="{{ route('admin.hrm.applications.index') }}" class="dashboard-subnav-link">Applications</a>
        <a href="{{ route('admin.hrm.interviews.index') }}" class="dashboard-subnav-link">Interviews</a>
        <a href="{{ route('admin.hrm.compensation.index') }}" class="dashboard-subnav-link">Compensation</a>
        <a href="{{ route('admin.hrm.expenses.index') }}" class="dashboard-subnav-link">Expenses</a>
        <a href="{{ route('admin.hrm.perks.index') }}" class="dashboard-subnav-link">Perks</a>
    </div>

    <div class="card">
        <div class="panel-title">Employee Directory</div>
        <div class="panel-subtitle">Use compensation, expenses, and perks tabs for operational records.</div>
        <div class="mt-6 overflow-x-auto">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Code</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Compensation</th>
                        <th>Expenses</th>
                        <th>Perks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td>
                                <div class="font-semibold text-slate-800">{{ $employee->user?->name }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ $employee->user?->email }}</div>
                            </td>
                            <td>{{ $employee->employee_code }}</td>
                            <td>{{ $employee->department?->name ?? 'General' }}</td>
                            <td><span class="status-badge">{{ str($employee->employment_status)->title() }}</span></td>
                            <td>{{ $employee->compensationRecords->count() }}</td>
                            <td>{{ $employee->expenseClaims->count() }}</td>
                            <td>{{ $employee->perks->count() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
