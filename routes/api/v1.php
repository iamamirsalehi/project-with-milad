<?php

use App\Modules\Movie\Http\Controllers\API\V1\AdminMovieController;
use App\Modules\Movie\Http\Controllers\API\V1\MovieController;
use App\Modules\Movie\Http\Controllers\API\V1\AdminMovieStatusController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('admin/movie')->group(function () {
        Route::get('', [AdminMovieController::class, 'get']);
        Route::post('{imdbID}/video', [AdminMovieController::class, 'uploadVideo']);
        Route::put('{imdbID}/publish', [AdminMovieStatusController::class, 'publish']);
        Route::put('{imdbID}/draft', [AdminMovieStatusController::class, 'draft']);
    });

    Route::prefix('movie')->group(function () {
        Route::get('', [MovieController::class, 'get']);
    });
});
