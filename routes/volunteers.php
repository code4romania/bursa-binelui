<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('ong')->middleware('auth')->group(function () {
    Route::get('voluntari/{status?}', [\App\Http\Controllers\Ngo\VolunteerController::class, 'index'])->name('admin.ong.volunteers');
    Route::post('voluntari/approve/{id}', [\App\Http\Controllers\Ngo\VolunteerController::class, 'approve'])->name('admin.ong.volunteers.approve');
    Route::post('voluntari/reject/{id}', [\App\Http\Controllers\Ngo\VolunteerController::class, 'reject'])->name('admin.ong.volunteers.reject');
    Route::post('voluntari/delete/{id}', [\App\Http\Controllers\Ngo\VolunteerController::class, 'delete'])->name('admin.ong.volunteers.delete');
});
