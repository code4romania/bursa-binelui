<?php

declare(strict_types=1);

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BcrProjectController;
use App\Http\Controllers\EvolutionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
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
Route::group(['prefix' => 'proiect-bcr', 'as' => 'bcr.'], function () {
    Route::get('/', [BcrProjectController::class, 'index'])->name('index');
    Route::get('/{project:slug}', [BcrProjectController::class, 'show'])->name('show');
});

require __DIR__ . '/auth.php';

require __DIR__ . '/donations.php';

require __DIR__ . '/championship.php';

require __DIR__ . '/regional.php';

Route::get('/evolutia-faptelor-bune', EvolutionController::class)->name('evolution');

Route::group([
    'prefix' => 'articles',
    'as' => 'articles.',
    'controller' => ArticleController::class,
], function () {
    Route::get('/', 'index')->name('index');
    Route::get('/category/{category:slug}', 'category')->name('category');
    Route::get('/{article:slug}', 'show')->name('show');
});

Route::group([
    'prefix' => 'organizations',
    'as' => 'organizations.',
    'controller' => OrganizationController::class,
], function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{organization:slug}', 'show')->name('show');
    Route::post('/{organization:slug}/volunteer', 'volunteer')->name('volunteer');
});

Route::group([
    'prefix' => 'projects',
    'as' => 'projects.',
    'controller' => ProjectController::class,
], function () {
    Route::get('/', 'index')->name('index');
    Route::get('/map', 'map')->name('map');
    Route::get('/{project:slug}', 'show')->name('show');
    Route::post('/{project:slug}/donate', 'donate')->name('donate');
    Route::post('/{project:slug}/volunteer', 'volunteer')->name('volunteer');
});

Route::get('/{page:slug}', PageController::class)->name('page');
