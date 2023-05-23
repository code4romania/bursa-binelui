<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::prefix('ong')->middleware('auth')->group(function () {
    Route::get('voluntari', function () {
        return Inertia::render('AdminOng/Volunteers/Volunteers');
    })->name('admin.ong.volunteers');
});
