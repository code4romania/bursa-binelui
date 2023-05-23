<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/* Tichets routes. */
Route::prefix('ong')->middleware('auth')->group(function () {
    Route::get('/tichete-deschise', function () {
        return Inertia::render('AdminOng/Tichets/OpenTickets');
    })->name('admin.ong.tickets.open');
    Route::get('/tichete-inchise', function () {
        return Inertia::render('AdminOng/Tichets/ClosedTickets');
    })->name('admin.ong.tickets.closed');
    Route::get('/tichet/{tichet}', function () {
        return Inertia::render('AdminOng/Tichets/Ticket');
    })->name('admin.ong.tickets.view');
});
