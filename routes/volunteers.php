<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::prefix('ong')->middleware('auth')->group(function () {
    Route::get('voluntari/{status?}', [\App\Http\Controllers\Ngo\VolunteerController::class, 'index'])->name('admin.ong.volunteers');;
});
