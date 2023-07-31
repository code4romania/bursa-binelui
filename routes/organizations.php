<?php

declare(strict_types=1);

use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;

/* Public routes. */
Route::get('organizatii', [OrganizationController::class, 'index'])->name('organizations');
Route::get('organizatie/{organization}', [OrganizationController::class, 'show'])->name('organization');
Route::post('/organizatie/{organization}/voluntar', [OrganizationController::class, 'volunteer'])->name('organization.volunteer');

/* Admin Ong routes. */
Route::prefix('ong')->middleware('auth')->group(function () {
    Route::get('organizatie', [OrganizationController::class, 'edit'])->name('admin.ong.edit');
    Route::delete('organizatie/remove-cover-image', [OrganizationController::class, 'removeCoverImage'])->name('organization.remove_cover_image');
    Route::post('organizatie/update/{organization}', [OrganizationController::class, 'update'])->name('admin.ong.update');
});
