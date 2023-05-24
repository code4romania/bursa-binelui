<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\ProjectController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/* Public routes. */
Route::get('/proiecte', function () {
    return Inertia::render('Public/Projects/Projects');
})->name('projects');
Route::get('/proiect/{proiect}', function () {
    return Inertia::render('Public/Projects/Project');
})->name('project');

/* Ong routes. */
Route::prefix('ong')->middleware('auth')->group(function () {
    Route::get('proiecte', [ProjectController::class, 'index'])->name('admin.ong.projects');

    Route::get('add-proiect', [ProjectController::class, 'create'])->name('admin.ong.project.add');
    Route::post('add-proiect', [ProjectController::class, 'store'])->name('admin.ong.project.store');
    Route::get('edit-proiect/{project}', [ProjectController::class, 'edit'])->name('admin.ong.project.edit');
    Route::put('edit-proiect/{project}', [ProjectController::class, 'update'])->name('admin.ong.project.update');
});
