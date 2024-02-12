<?php

declare(strict_types=1);

use App\Http\Controllers\DonationController;
use Illuminate\Support\Facades\Route;

/* Public routes. */
Route::post('/doneaza/thanks/{uuid}', [DonationController::class, 'thankYou'])->name('donation.thanks');
Route::get('/doneaza/callbacks/{uuid}', [DonationController::class, 'makeDonation'])->name('donation.callback');
Route::get('/doneaza/{donation:uuid}', [DonationController::class, 'makeDonation'])->name('donation.make');
