<?php

use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;

/** Public routes. */
Route::get('organizatii', [OrganizationController::class, 'index'])->name('organizations');
Route::get('organizatie/{organization}', [OrganizationController::class, 'show'])->name('organization');

/** Admin routes. */
Route::middleware('auth')->group(function () {

});
