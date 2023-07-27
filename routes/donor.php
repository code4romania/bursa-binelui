<?php

declare(strict_types=1);

use App\Http\Controllers\DonorController;
use Illuminate\Support\Facades\Route;

/* Donor routes. */
// Route::prefix('donor')->middleware('auth')->group(function () {
//     Route::get('dashboard', [DonorController::class, 'index'])->name('admin.donor.index');
//     Route::get('donatii', [DonorController::class, 'index'])->name('admin.donor.donations');
// });

Route::get('donatiile-mele', [DonorController::class, 'donations'])->name('donor.donations');
Route::get('donor-dashboard', [DonorController::class, 'index'])->name('donor.index');
