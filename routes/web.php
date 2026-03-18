<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Website\FormController;
use App\Http\Controllers\Website\WebsiteController;
use Illuminate\Support\Facades\Route;

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
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
    Route::post('/login/quick/{role}', [AuthenticatedSessionController::class, 'quickLogin'])->name('login.quick');
});
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

Route::get('/billing', function () {
    return redirect()->away(rtrim(config('whmcs.base_url'), '/') . '/clientarea.php');
})->name('billing');

require __DIR__.'/modules/admin.php';
require __DIR__.'/modules/client.php';
require __DIR__.'/modules/employee.php';
