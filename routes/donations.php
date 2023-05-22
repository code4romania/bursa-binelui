<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/** Tichets routes. */
Route::prefix('ong')->middleware('auth')->group(function () {
    Route::get('/donatii', function () { return Inertia::render('AdminOng/Donations/Donations'); })->name('admin.ong.donations');
});
