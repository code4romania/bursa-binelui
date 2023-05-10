<?php

use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('organizatii', [OrganizationController::class, 'index'])->name('organizations');

    Route::get('organizatie/{organization}', [OrganizationController::class, 'show'])->name('organization');
});

Route::middleware('auth')->group(function () {

});
