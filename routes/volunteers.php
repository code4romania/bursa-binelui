<?php

declare(strict_types=1);

use App\Http\Controllers\Ngo\VolunteerController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth', 'verified'],
    'prefix' => 'dashboard/volunteers',
    'as' => 'dashboard.volunteers.',
    'controller' => VolunteerController::class,
], function () {
    Route::get('/{status?}', 'index')->name('index');

    Route::post('/{volunteerRequest}/approve', 'approve')->name('approve');
    Route::post('/{volunteerRequest}/reject', 'reject')->name('reject');
    Route::post('/{volunteerRequest}/delete', 'delete')->name('delete');
});
