<?php

use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/proiecte', function () {
    return Inertia::render('Public/Projects');
})->name('projects');

Route::get('/proiect/{proiect}', function () {
    return Inertia::render('Public/Project');
})->name('project');



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
