<?php

use App\Http\Controllers\Client\BillingRedirectController;
use App\Http\Controllers\Client\DashboardController;
use App\Http\Controllers\Client\DownloadsController;
use App\Http\Controllers\Client\DomainController;
use App\Http\Controllers\Client\DocumentController;
use App\Http\Controllers\Client\HostingController;
use App\Http\Controllers\Client\InvoiceController;
use App\Http\Controllers\Client\StoreInvoiceController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\SupportController;
use App\Http\Controllers\Store\DownloadController as StoreDownloadController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::get('/billing', [BillingRedirectController::class, 'portal'])->name('billing.portal');
    Route::get('/billing/invoices/{invoiceId}', [BillingRedirectController::class, 'invoice'])->name('billing.invoice');
    Route::get('/billing/domains/{domainId}', [BillingRedirectController::class, 'domain'])->name('billing.domain');
    Route::get('/billing/services/{serviceId}', [BillingRedirectController::class, 'service'])->name('billing.service');
    Route::get('/hosting', HostingController::class)->name('hosting.index');
    Route::get('/domains', DomainController::class)->name('domains.index');
    Route::get('/invoices', InvoiceController::class)->name('invoices.index');
    Route::get('/store-invoices', [StoreInvoiceController::class, 'index'])->name('store-invoices.index');
    Route::get('/store-invoices/{invoice}', [StoreInvoiceController::class, 'show'])->name('store-invoices.show');
    Route::get('/store-invoices/{invoice}/download', [StoreInvoiceController::class, 'download'])->name('store-invoices.download');
    Route::get('/downloads', DownloadsController::class)->name('downloads.index');
    Route::get('/downloads/{entitlement}', [StoreDownloadController::class, 'entitlement'])->name('downloads.download');
    Route::get('/support', [SupportController::class, 'index'])->name('support.index');
    Route::post('/support', [SupportController::class, 'store'])->name('support.store');
    Route::post('/support/{ticket}/reply', [SupportController::class, 'reply'])->name('support.reply');
    Route::get('/documents', DocumentController::class)->name('documents.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
