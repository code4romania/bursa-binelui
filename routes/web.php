<?php

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/** Website routes. */
Route::get('/despre', function () { return Inertia::render('Public/Website/About'); })->name('about');
Route::get('/termenii-si-conditii', function () { return Inertia::render('Public/Website/Terms'); })->name('terms');
Route::get('/politica-de-confidentialitate', function () { return Inertia::render('Public/Website/Policy'); })->name('policy');
Route::get('/contact', function () { return Inertia::render('Public/Website/Contact'); })->name('contact');
Route::get('/donator', function () { return Inertia::render('Public/Donor/Donor'); })->name('donor');
Route::get('/multumim', function () { return Inertia::render('Public/Donor/ThankYou'); })->name('thanks');
Route::get('/articles', function () { return Inertia::render('Public/Articles/Articles'); })->name('articles');
Route::get('/gallery/{project}', function () { return Inertia::render('Public/Projects/Gallery'); })->name('gallery');
Route::get('/bcr/proiecte', function () { return Inertia::render('Public/Bcr/Projects'); })->name('bcr.projects');
Route::get('/campionatul-de-bine', function () { return Inertia::render('Public/Championship/Championship'); })->name('championship');

require __DIR__.'/auth.php';

require __DIR__.'/organizations.php';

require __DIR__.'/projects.php';

require __DIR__.'/volunteers.php';
