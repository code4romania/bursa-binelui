<?php

declare(strict_types=1);

use App\Http\Controllers\RegionalController;
use Illuminate\Support\Facades\Route;

/* Public routes. */
Route::get('gale-regionale', [RegionalController::class, 'index'])->name('regional');
Route::get('editia-anterioara/{year}', [RegionalController::class, 'edition'])->name('lastedition');
Route::get('proiect-gale/{project:slug}', [RegionalController::class, 'project'])->name('regional.project');
