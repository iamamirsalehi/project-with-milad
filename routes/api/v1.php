<?php

use App\Http\Controllers\API\V1\AdminMovieController;
use App\Http\Controllers\API\V1\MovieController;
use App\Http\Controllers\API\V1\AdminSubscriptionController;
use App\Http\Controllers\API\V1\UserSubscriptionController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('admin/movie')->group(function () {
        Route::get('', [AdminMovieController::class, 'get']);
        Route::post('', [AdminMovieController::class, 'add']);
        Route::post('{imdbID}/video', [AdminMovieController::class, 'uploadVideo']);
        Route::put('{imdbID}/publish', [AdminMovieController::class, 'publish']);
        Route::put('{imdbID}/draft', [AdminMovieController::class, 'draft']);
    });

    Route::prefix('admin/subscription')->group(function () {
        Route::post('', [AdminSubscriptionController::class, 'add']);
    });

    Route::prefix('movie')->group(function () {
        Route::get('', [MovieController::class, 'get']);
    });

    Route::post('subscribe', [UserSubscriptionController::class, 'subscribe']);
});
