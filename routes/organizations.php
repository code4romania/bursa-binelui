<?php

declare(strict_types=1);

use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;

/* Public routes. */
Route::get('organizatii', [OrganizationController::class, 'index'])->name('organizations');
Route::get('organizatie/{organization}', [OrganizationController::class, 'show'])->name('organization');
Route::post('organizatie/{organization}/voluntar', [OrganizationController::class, 'volunteer'])->name('organization.volunteer');

Route::group([
    'middleware' => ['auth', 'verified'],
    'prefix' => 'dashboard/organization',
    'as' => 'dashboard.organization.',
    'controller' => \App\Http\Controllers\Ngo\OrganizationController::class,
], function () {
    Route::get('/', 'edit')->name('edit');
    Route::post('/', 'update')->name('update');
});
