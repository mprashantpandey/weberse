<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\AccountClaimController;
use App\Http\Controllers\Auth\TwoFactorChallengeController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\Store\CheckoutController;
use App\Http\Controllers\Store\DownloadController as StoreDownloadController;
use App\Http\Controllers\Store\StorefrontController;
use App\Http\Controllers\Webhooks\RazorpayWebhookController;
use App\Http\Controllers\Website\FormController;
use App\Http\Controllers\Website\WebsiteController;
use App\Services\Settings\SiteSettingsService;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

Route::get('/', [WebsiteController::class, 'home'])->name('website.home');
Route::get('/about', [WebsiteController::class, 'about'])->name('website.about');
Route::get('/services', [WebsiteController::class, 'services'])->name('website.services');
Route::get('/services/{slug}', [WebsiteController::class, 'service'])->name('website.services.show');
Route::get('/portfolio', [WebsiteController::class, 'portfolio'])->name('website.portfolio');
Route::get('/portfolio/{slug}', [WebsiteController::class, 'project'])->name('website.portfolio.show');
Route::get('/case-studies', [WebsiteController::class, 'caseStudies'])->name('website.case-studies.index');
Route::get('/case-studies/{slug}', [WebsiteController::class, 'caseStudy'])->name('website.case-studies.show');
Route::get('/blog', [WebsiteController::class, 'blog'])->name('website.blog.index');
Route::get('/blog/{post:slug}', [WebsiteController::class, 'blogPost'])->name('website.blog.show');
Route::get('/careers', [WebsiteController::class, 'careers'])->name('website.careers');
Route::get('/careers/{jobOpening:slug}/apply', [WebsiteController::class, 'apply'])->name('website.careers.apply-page');
Route::get('/hosting', [WebsiteController::class, 'hosting'])->name('website.hosting');
Route::get('/contact', [WebsiteController::class, 'contact'])->name('website.contact');
Route::get('/pricing', [WebsiteController::class, 'pricing'])->name('website.pricing');
Route::get('/privacy-policy', [WebsiteController::class, 'privacy'])->name('website.privacy');
Route::get('/terms', [WebsiteController::class, 'terms'])->name('website.terms');
Route::post('/contact', [FormController::class, 'contact'])->name('website.contact.submit');
Route::post('/newsletter/subscribe', [FormController::class, 'newsletter'])->name('website.newsletter.subscribe');
Route::post('/careers/apply', [FormController::class, 'apply'])->name('website.careers.apply');
Route::post('/careers/{jobOpening:slug}/apply', [FormController::class, 'apply'])->name('website.careers.apply.legacy');

// CSRF-free lead intake for WHMCS pages (same domain, different app).
Route::post('/lead-intake/whmcs', [FormController::class, 'whmcsLead'])
    ->middleware('throttle:30,1')
    ->name('website.lead-intake.whmcs');

// Store (digital products) checkout endpoints.
Route::prefix('store')->name('store.')->group(function () {
    Route::get('/', [StorefrontController::class, 'index'])->name('index');
    Route::get('/{product:slug}', [StorefrontController::class, 'show'])->name('show');

    Route::post('/checkout/create', [CheckoutController::class, 'create'])
        ->middleware('throttle:20,1')
        ->name('checkout.create');
    Route::post('/checkout/confirm', [CheckoutController::class, 'confirm'])
        ->middleware('throttle:40,1')
        ->name('checkout.confirm');

    Route::get('/d/{token}', [StoreDownloadController::class, 'token'])
        ->middleware('throttle:60,1')
        ->name('download.token');
});

// Razorpay webhooks (CSRF-free).
Route::post('/webhooks/razorpay', RazorpayWebhookController::class)
    ->withoutMiddleware([VerifyCsrfToken::class])
    ->middleware('throttle:120,1')
    ->name('webhooks.razorpay');
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
    Route::post('/login/quick/{role}', [AuthenticatedSessionController::class, 'quickLogin'])->name('login.quick');

    Route::get('/account/claim/{token}', [AccountClaimController::class, 'show'])->name('account.claim.show');
    Route::post('/account/claim/{token}', [AccountClaimController::class, 'store'])->name('account.claim.store');
    Route::get('/two-factor-challenge', [TwoFactorChallengeController::class, 'create'])->name('two-factor.create');
    Route::post('/two-factor-challenge', [TwoFactorChallengeController::class, 'store'])->name('two-factor.store');
    Route::post('/two-factor-challenge/resend', [TwoFactorChallengeController::class, 'resend'])->name('two-factor.resend');
});
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/security', [SecurityController::class, 'index'])->name('security.index');
    Route::patch('/security/two-factor', [SecurityController::class, 'updateTwoFactor'])->name('security.two-factor.update');
    Route::delete('/security/sessions/{sessionId}', [SecurityController::class, 'destroySession'])->name('security.sessions.destroy');
    Route::delete('/security/sessions', [SecurityController::class, 'destroyOtherSessions'])->name('security.sessions.destroy-others');
});

Route::get('/billing', function () {
    $whmcs = app(SiteSettingsService::class)->getWhmcsSettings();

    return redirect()->away(rtrim((string) ($whmcs['base_url'] ?? config('whmcs.base_url')), '/') . (($whmcs['sso_redirect'] ?? '/clientarea.php') ?: '/clientarea.php'));
})->name('billing');

require __DIR__.'/modules/admin.php';
require __DIR__.'/modules/client.php';
require __DIR__.'/modules/employee.php';
