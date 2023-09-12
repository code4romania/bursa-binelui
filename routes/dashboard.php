<?php

declare(strict_types=1);

use App\Http\Controllers\Dashboard\DonationController;
use App\Http\Controllers\Dashboard\OrganizationController;
use App\Http\Controllers\Dashboard\ProjectController;
use App\Http\Controllers\Dashboard\RegionalProjectController;
use App\Http\Controllers\Dashboard\TicketController;
use App\Http\Controllers\Dashboard\VolunteerController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'organization',
    'as' => 'organization.',
    'controller' => OrganizationController::class,
], function () {
    Route::get('/', 'edit')->name('edit');
    Route::post('/', 'update')->name('update');
});

Route::group([
    'prefix' => 'projects',
    'as' => 'projects.',
    'controller' => ProjectController::class,
], function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/', 'store')->name('store');
    Route::get('/{project}/edit', 'edit')->name('edit');
    Route::post('/{project}/status', 'changeStatus')->name('status');
    Route::put('/{project}', 'update')->name('update');

    Route::group([
        'prefix' => 'regional',
        'as' => 'regional.',
        'controller' => RegionalProjectController::class,
    ], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{project}/edit', 'edit')->name('edit');
        Route::post('/{project}/status', 'changeStatus')->name('status');
        Route::put('/{project}', 'update')->name('update');
    });
});

Route::group([
    'prefix' => 'volunteers',
    'as' => 'volunteers.',
    'controller' => VolunteerController::class,
], function () {
    Route::get('/{status?}', 'index')->name('index');

    Route::post('/{volunteerRequest}/approve', 'approve')->name('approve');
    Route::post('/{volunteerRequest}/reject', 'reject')->name('reject');
    Route::post('/{volunteerRequest}/delete', 'delete')->name('delete');
});

Route::group([
    'prefix' => 'donations',
    'as' => 'donations.',
    'controller' => DonationController::class,
], function () {
    Route::get('/', 'index')->name('index');
});

Route::group([
    'prefix' => 'tickets',
    'as' => 'tickets.',
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
