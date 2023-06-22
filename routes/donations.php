<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/* Public routes. */
Route::get('/doneaza/{donation:uuid}', [\App\Http\Controllers\DonationController::class, 'makeDonation'])->name('donation.make');
Route::get('/doneaza/callbacks/{uuid}', [\App\Http\Controllers\DonationController::class, 'makeDonation'])->name('donation.callback');
Route::post('/doneaza/thanks/{uuid}', [\App\Http\Controllers\DonationController::class, 'thankYou'])->name('donation.thanks');
/* Tichets routes. */
Route::prefix('ong')->middleware('auth')->group(function () {
    Route::get('/donatii', function () {
        return Inertia::render('AdminOng/Donations/Donations');
    })->name('admin.ong.donations');
});
