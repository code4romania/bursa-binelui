<?php

declare(strict_types=1);

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth', 'verified'],
    'prefix' => 'dashboard/tickets',
    'as' => 'dashboard.tickets.',
    'controller' => TicketController::class,
], function () {
    Route::get('/{status?}', 'index')
        ->whereIn('status', ['open', 'closed'])
        ->name('index');

    Route::post('/', 'store')->name('store');

    Route::get('/{ticket}', 'show')->name('view');
    Route::post('/{ticket}/reply', 'reply')->name('reply');
    Route::post('/{ticket}/status', 'status')
        ->whereIn('status', ['open', 'closed'])
        ->name('status');
});
