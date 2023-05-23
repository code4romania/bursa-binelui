<?php

declare(strict_types=1);

use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;

/* Public routes. */
Route::get('organizatii', [OrganizationController::class, 'index'])->name('organizations');
Route::get('organizatie/{organization}', [OrganizationController::class, 'show'])->name('organization');

/* Admin Ong routes. */
Route::prefix('ong')->middleware('auth')->group(function () {
    Route::get('organizatie/{organization}', [OrganizationController::class, 'edit'])->name('admin.ong.edit');
    Route::put('organizatie/update/{organization}', [OrganizationController::class, 'update'])->name('admin.ong.update');
});
