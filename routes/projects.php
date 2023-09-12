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
