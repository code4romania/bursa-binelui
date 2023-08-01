<?php

declare(strict_types=1);

use App\Http\Controllers\RegionalController;
use Illuminate\Support\Facades\Route;

/* Public routes. */
Route::get('gale-regionale', [RegionalController::class, 'index'])->name('regional');
Route::get('regional-editia/{year}', [RegionalController::class, 'edition'])->name('regional.edition.year');
Route::get('region-editia/{id}', [RegionalController::class, 'regionalEdition'])->name('regional.edition.region');
Route::get('proiect-gale/{project:slug}', [RegionalController::class, 'project'])->name('regional.project');
Route::get('reguli-gale-regionale', [RegionalController::class, 'regionalRules'])->name('regional.rules');
