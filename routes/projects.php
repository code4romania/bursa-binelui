<?php

use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('guest')->group(function () {

});

Route::prefix('ong')->middleware('auth')->group(function () {
    Route::get('proiecte', function () {
        return Inertia::render('AdminOng/Projects/Projects');
    })->name('admin.ong.projects');

    Route::get('proiect/{proiect}', function () {
        return Inertia::render('AdminOng/Projects/Project');
    })->name('admin.ong.project.view');

    Route::get('add-proiect/{proiect}', function () {
        return Inertia::render('AdminOng/Projects/AddProject');
    })->name('admin.ong.project.add');

    Route::get('edit-proiect/{proiect}', function () {
        return Inertia::render('AdminOng/Projects/EditProject');
    })->name('admin.ong.project.edit');
});
