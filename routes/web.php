<?php

declare(strict_types=1);

use App\Http\Controllers\AdminBBTemporary;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// Route::get('/', function () {
//     return Inertia::render('Public/Home');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* Website routes. */
Route::get('/despre', [AdminBBTemporary::class, 'about'])->name('about');
Route::get('/intrebari-frecvente', [AdminBBTemporary::class, 'faqs'])->name('faqs');

Route::get('/termenii-si-conditii', function () {
    return Inertia::render('Public/Website/Terms');
})->name('terms');
Route::get('/politica-de-confidentialitate', function () {
    return Inertia::render('Public/Website/Policy');
})->name('policy');
Route::get('/contact', function () {
    return Inertia::render('Public/Website/Contact');
})->name('contact');
Route::get('/donator', function () {
    return Inertia::render('Public/Donor/Donor');
})->name('donor');
Route::get('/multumim', function () {
    return Inertia::render('Public/VolunteerThankYou');
})->name('volunteer.thanks');

Route::get('/gallery/{project}', function () {
    return Inertia::render('Public/Projects/Gallery');
})->name('gallery');
Route::get('/bcr/proiecte', function () {
    return Inertia::render('Public/Bcr/Projects');
})->name('bcr.projects');

require __DIR__ . '/auth.php';

require __DIR__ . '/organizations.php';

require __DIR__ . '/projects.php';

require __DIR__ . '/volunteers.php';

require __DIR__ . '/tickets.php';

require __DIR__ . '/donations.php';

require __DIR__ . '/championship.php';

require __DIR__ . '/regional.php';

require __DIR__ . '/articles.php';

require __DIR__ . '/donor.php';

require __DIR__ . '/evolution.php';

Route::get('/{page:slug}', PageController::class)->name('page');
