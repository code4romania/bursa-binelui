<?php

declare(strict_types=1);

use App\Http\Controllers\Ngo\OrganizationController as NGOOrganizationController;
use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;

/* Public routes. */
Route::get('organizatii', [OrganizationController::class, 'index'])->name('organizations');
Route::get('organizatie/{organization}', [OrganizationController::class, 'show'])->name('organization');
Route::post('organizatie/{organization}/voluntar', [OrganizationController::class, 'volunteer'])->name('organization.volunteer');

/* Admin Ong routes. */
Route::prefix('ong')->middleware(['auth', 'verified'])->group(function () {
    Route::get('organizatie', [NGOOrganizationController::class, 'edit'])->name('admin.ong.edit');
    Route::post('organizatie', [NGOOrganizationController::class, 'update'])->name('admin.ong.update');
});
