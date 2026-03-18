<?php

use App\Http\Controllers\Employee\WorkspaceController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin|hr|sales|support'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/', [WorkspaceController::class, 'dashboard'])->name('dashboard');
    Route::get('/leaves', [WorkspaceController::class, 'leaves'])->name('leaves.index');
    Route::post('/leaves', [WorkspaceController::class, 'storeLeave'])->name('leaves.store');
    Route::get('/expenses', [WorkspaceController::class, 'expenses'])->name('expenses.index');
    Route::post('/expenses', [WorkspaceController::class, 'storeExpense'])->name('expenses.store');
    Route::get('/compensation', [WorkspaceController::class, 'compensation'])->name('compensation.index');
    Route::get('/perks', [WorkspaceController::class, 'perks'])->name('perks.index');
    Route::get('/profile', [WorkspaceController::class, 'profile'])->name('profile.index');
    Route::patch('/profile', [WorkspaceController::class, 'updateProfile'])->name('profile.update');
});
