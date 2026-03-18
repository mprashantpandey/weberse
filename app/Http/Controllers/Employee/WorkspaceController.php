<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\HRM\CompensationRecord;
use App\Models\HRM\EmployeePerk;
use App\Models\HRM\ExpenseClaim;
use App\Models\HRM\LeaveRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WorkspaceController extends Controller
{
    public function dashboard(Request $request): View
    {
        $profile = $request->user()->employeeProfile()->with(['department', 'leaveRequests', 'expenseClaims', 'compensationRecords', 'perks'])->first();

        return view('employee.dashboard.index', [
            'profile' => $profile,
            'summary' => [
                'pending_leaves' => $profile?->leaveRequests()->where('status', 'pending')->count() ?? 0,
                'pending_expenses' => $profile?->expenseClaims()->where('status', 'pending')->count() ?? 0,
                'active_perks' => $profile?->perks()->where('status', 'active')->count() ?? 0,
                'active_compensation' => $profile?->compensationRecords()->where('status', 'active')->count() ?? 0,
            ],
            'recentLeaves' => $profile?->leaveRequests()->latest()->take(5)->get() ?? collect(),
            'recentExpenses' => $profile?->expenseClaims()->latest('expense_date')->take(5)->get() ?? collect(),
            'activePerks' => $profile?->perks()->where('status', 'active')->latest()->take(4)->get() ?? collect(),
        ]);
    }

    public function leaves(Request $request): View
    {
        $profile = $request->user()->employeeProfile()->with('department')->firstOrFail();

        return view('employee.leaves.index', [
            'profile' => $profile,
            'leaves' => $profile->leaveRequests()->latest('start_date')->get(),
        ]);
    }

    public function storeLeave(Request $request): RedirectResponse
    {
        $profile = $request->user()->employeeProfile()->firstOrFail();

        $data = $request->validate([
            'type' => ['required', 'string', 'max:50'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['nullable', 'string'],
        ]);

        $profile->leaveRequests()->create([
            ...$data,
            'status' => 'pending',
        ]);

        return back()->with('status', 'Leave request submitted.');
    }

    public function expenses(Request $request): View
    {
        $profile = $request->user()->employeeProfile()->with('department')->firstOrFail();

        return view('employee.expenses.index', [
            'profile' => $profile,
            'expenses' => $profile->expenseClaims()->latest('expense_date')->get(),
        ]);
    }

    public function storeExpense(Request $request): RedirectResponse
    {
        $profile = $request->user()->employeeProfile()->firstOrFail();

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'amount' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:10'],
            'expense_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
            'receipt' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:8192'],
        ]);

        $profile->expenseClaims()->create([
            ...$data,
            'submitted_by' => $request->user()->id,
            'status' => 'pending',
            'receipt_path' => $request->file('receipt')?->store('expense-receipts', 'public'),
        ]);

        return back()->with('status', 'Expense claim submitted.');
    }

    public function compensation(Request $request): View
    {
        $profile = $request->user()->employeeProfile()->with('department')->firstOrFail();

        return view('employee.compensation.index', [
            'profile' => $profile,
            'records' => $profile->compensationRecords()->latest('effective_from')->get(),
        ]);
    }

    public function perks(Request $request): View
    {
        $profile = $request->user()->employeeProfile()->with('department')->firstOrFail();

        return view('employee.perks.index', [
            'profile' => $profile,
            'perks' => $profile->perks()->latest()->get(),
        ]);
    }

    public function profile(Request $request): View
    {
        $profile = $request->user()->employeeProfile()->with('department')->first();

        return view('employee.profile.index', [
            'profile' => $profile,
            'user' => $request->user(),
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = $request->user();
        $profile = $user->employeeProfile()->firstOrFail();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'emergency_contact' => ['nullable', 'string', 'max:255'],
        ]);

        $user->update([
            'name' => $data['name'],
            'phone' => $data['phone'] ?? null,
            'job_title' => $data['job_title'] ?? null,
        ]);

        $profile->update([
            'emergency_contact' => $data['emergency_contact'] ?? null,
        ]);

        return back()->with('status', 'Employee profile updated.');
    }
}
