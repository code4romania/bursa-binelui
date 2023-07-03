<?php

declare(strict_types=1);

use App\Http\Controllers\EvolutionController;
use Illuminate\Support\Facades\Route;


Route::get('donatiile-mele', [DonorController::class, 'donations'])->name('donor.donations');
Route::get('/evolutia-faptelor-bune', [EvolutionController::class, 'index'])->name('evolution');
