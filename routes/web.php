<?php

declare(strict_types=1);

use App\Http\Controllers\EvolutionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::inertia('/termenii-si-conditii', 'Public/Website/Terms')->name('terms');
Route::inertia('/politica-de-confidentialitate', 'Public/Website/Policy')->name('policy');
Route::inertia('/contact', 'Public/Website/Contact')->name('contact');
Route::inertia('/donator', 'Public/Donor/Donor')->name('donor');
Route::inertia('/multumim', 'Public/VolunteerThankYou')->name('volunteer.thanks');

Route::inertia('/gallery/{project}', 'Public/Projects/Gallery')->name('gallery');
Route::inertia('/bcr/proiecte', 'Public/Bcr/Projects')->name('bcr.projects');

require __DIR__ . '/auth.php';

require __DIR__ . '/organizations.php';

require __DIR__ . '/projects.php';

require __DIR__ . '/donations.php';

require __DIR__ . '/championship.php';

require __DIR__ . '/regional.php';

require __DIR__ . '/articles.php';

require __DIR__ . '/donor.php';

Route::get('/evolutia-faptelor-bune', EvolutionController::class)->name('evolution');

Route::get('/{page:slug}', PageController::class)->name('page');
