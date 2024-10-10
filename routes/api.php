<?php

use App\Http\Controllers\API\V1\MovieController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('movie')->group(function () {
        Route::get('', [MovieController::class, 'get']);
        Route::post('{imdbID}/upload', [MovieController::class, 'upload']);
    });
});
