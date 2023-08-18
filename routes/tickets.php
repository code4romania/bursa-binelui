<?php

declare(strict_types=1);

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

/* Tichets routes. */
Route::prefix('ong/tickets')->middleware('auth')->group(function () {
    Route::get('/{status}', [TicketController::class, 'index'])
        ->whereIn('status', ['open', 'closed'])
        ->name('admin.ong.tickets.index');

    Route::post('/', [TicketController::class, 'store'])->name('admin.ong.tickets.store');

    Route::get('/{ticket}', [TicketController::class, 'show'])->name('admin.ong.tickets.view');
    Route::post('/{ticket}/reply', [TicketController::class, 'reply'])->name('admin.ong.tickets.reply');
});
