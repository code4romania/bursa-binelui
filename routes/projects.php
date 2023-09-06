<?php

declare(strict_types=1);

use App\Http\Controllers\Ngo\ProjectController;
use App\Http\Controllers\Ngo\RegionalProjectController;
use Illuminate\Support\Facades\Route;

/* Public routes. */
Route::get('/proiecte', [\App\Http\Controllers\ProjectController::class, 'index'])->name('projects');
Route::get('/proiect/{project:slug}', [\App\Http\Controllers\ProjectController::class, 'show'])->name('project');
Route::post('/proiect/{project:slug}/donatie', [\App\Http\Controllers\ProjectController::class, 'donation'])->name('project.donation');
Route::post('/proiect/{project:slug}/voluntar', [\App\Http\Controllers\ProjectController::class, 'volunteer'])->name('project.volunteer');

/* Ong routes. */
Route::prefix('ong')->middleware(['auth', 'verified'])->group(function () {
    Route::get('proiecte', [ProjectController::class, 'index'])->name('admin.ong.projects');
    Route::post('project/change-status/{project}', [ProjectController::class, 'changeStatus'])->name('admin.ong.project.change-status');
    Route::get('add-proiect', [ProjectController::class, 'create'])->name('admin.ong.project.add');
    Route::post('add', [ProjectController::class, 'store'])->name('admin.ong.project.store');
    Route::get('edit/{project}', [ProjectController::class, 'edit'])->name('admin.ong.project.edit');
    Route::put('edit/{project}', [ProjectController::class, 'update'])->name('admin.ong.project.update');
    Route::prefix('regional')->group(function () {
        Route::get('/', [RegionalProjectController::class, 'index'])->name('admin.ong.regional.projects');
        Route::get('/add', [RegionalProjectController::class, 'create'])->name('admin.ong.regional.project.add');
        Route::get('/edit/{project}', [RegionalProjectController::class, 'edit'])->name('admin.ong.regional.project.edit');
        Route::post('/edit/{project}', [RegionalProjectController::class, 'update'])->name('admin.ong.regional.project.update');
        Route::post('/store', [RegionalProjectController::class, 'store'])->name('admin.ong.regional.project.create');
        Route::post('/change-status/{project}', [RegionalProjectController::class, 'changeStatus'])->name('admin.ong.regional.project.change-status');
    });
});
