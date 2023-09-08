<?php

declare(strict_types=1);

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

/* Public routes. */
Route::get('/proiecte', [ProjectController::class, 'index'])->name('projects');
Route::get('/proiecte/harta', [ProjectController::class, 'map'])->name('projects.map');
Route::get('/proiect/{project:slug}', [ProjectController::class, 'show'])->name('project');
Route::post('/proiect/{project:slug}/donatie', [ProjectController::class, 'donation'])->name('project.donation');
Route::post('/proiect/{project:slug}/voluntar', [ProjectController::class, 'volunteer'])->name('project.volunteer');

/* Ong routes. */
Route::group([
    'middleware' => ['auth', 'verified'],
    'prefix' => 'dashboard/projects',
    'as' => 'dashboard.projects.',
    'controller' => \App\Http\Controllers\Ngo\ProjectController::class,
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
        'controller' => \App\Http\Controllers\Ngo\RegionalProjectController::class,
    ], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{project}/edit', 'edit')->name('edit');
        Route::post('/{project}/status', 'changeStatus')->name('status');
        Route::put('/{project}', 'update')->name('update');
    });
});
