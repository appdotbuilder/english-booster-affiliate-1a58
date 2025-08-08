<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminSaleController;
use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\AffiliateManagementController;
use App\Http\Controllers\AffiliateReportController;
use App\Http\Controllers\AffiliateTrackingController;
use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

// Affiliate tracking route (public)
Route::get('/affiliate/{trackingCode}/program/{programId}', [AffiliateTrackingController::class, 'show'])
    ->name('affiliate.track');

Route::middleware(['auth', 'verified'])->group(function () {
    // Redirect dashboard based on user role
    Route::get('dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('affiliate.dashboard');
        }
    })->name('dashboard');

    // Affiliate routes
    Route::prefix('affiliate')->name('affiliate.')->group(function () {
        Route::get('dashboard', [AffiliateController::class, 'index'])->name('dashboard');
        Route::post('create-link', [AffiliateController::class, 'store'])->name('store');
    });

    // Affiliate reports
    Route::resource('affiliate-reports', AffiliateReportController::class)->only(['index']);

    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware(\App\Http\Middleware\AdminAccess::class)->group(function () {
        Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
    });

    // Admin resource routes
    Route::middleware(\App\Http\Middleware\AdminAccess::class)->group(function () {
        Route::resource('affiliate-management', AffiliateManagementController::class);
        Route::resource('admin-reports', AdminReportController::class)->only(['index']);
        Route::resource('admin-sales', AdminSaleController::class)->only(['index', 'show', 'update']);
    });

    // Program management (admin only)
    Route::resource('programs', ProgramController::class)
        ->middleware(\App\Http\Middleware\AdminAccess::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
