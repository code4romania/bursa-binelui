<?php

declare(strict_types=1);

use App\Http\Controllers\Ngo\ProjectController;
use App\Http\Controllers\Ngo\RegionalProjectController;
use Illuminate\Support\Facades\Route;

/* Public routes. */
Route::get('/proiecte', [\App\Http\Controllers\ProjectController::class, 'index'])->name('projects');
Route::get('/proiect/{project:slug}', [\App\Http\Controllers\ProjectController::class, 'item'])->name('project');
Route::post('/proiect/{project:slug}/donatie', [\App\Http\Controllers\ProjectController::class, 'donation'])->name('project.donation');
Route::post('/proiect/{project:slug}/voluntar', [\App\Http\Controllers\ProjectController::class, 'volunteer'])->name('project.volunteer');

/* Ong routes. */
Route::prefix('ong')->middleware('auth')->group(function () {
    Route::get('proiecte', [ProjectController::class, 'index'])->name('admin.ong.projects');

    Route::get('add-proiect', [ProjectController::class, 'create'])->name('admin.ong.project.add');
    Route::post('add-proiect', [ProjectController::class, 'store'])->name('admin.ong.project.store');
    Route::get('edit-proiect/{project}', [ProjectController::class, 'edit'])->name('admin.ong.project.edit');
    Route::put('edit-proiect/{project}', [ProjectController::class, 'update'])->name('admin.ong.project.update');
    Route::prefix('regional')->group(function (){
        Route::get('/', [RegionalProjectController::class, 'index'])->name('admin.ong.regional.projects');
        Route::get('/add', [RegionalProjectController::class, 'create'])->name('admin.ong.regional.project.add');
        Route::post('/store', [RegionalProjectController::class, 'store'])->name('admin.ong.regional.project.create');
    });

});
