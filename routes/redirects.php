<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('BursaBinelui')->group(function () {
    Route::permanentRedirect('/', '/');

    Route::permanentRedirect('/ONG-uri/{organization?}', '/organizations/{organization?}');

    Route::permanentRedirect('/Proiecte/{project?}', '/projects/{project?}');
});
