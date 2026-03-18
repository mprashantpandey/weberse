<?php

use App\Http\Controllers\Client\DashboardController;
use App\Http\Controllers\Client\DocumentController;
use App\Http\Controllers\Client\HostingController;
use App\Http\Controllers\Client\InvoiceController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\SupportController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::get('/hosting', HostingController::class)->name('hosting.index');
    Route::get('/invoices', InvoiceController::class)->name('invoices.index');
    Route::get('/support', [SupportController::class, 'index'])->name('support.index');
    Route::post('/support', [SupportController::class, 'store'])->name('support.store');
    Route::post('/support/{ticket}/reply', [SupportController::class, 'reply'])->name('support.reply');
    Route::get('/documents', DocumentController::class)->name('documents.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
});
