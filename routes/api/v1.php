<?php

use App\Http\Controllers\API\V1\AdminMovieController;
use App\Http\Controllers\API\V1\UserMovieController;
use App\Http\Controllers\API\V1\AdminSubscriptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\UserFavoriteMovieController;
use App\Http\Controllers\API\V1\UserPaymentController;

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
        Route::get('genres', [UserMovieController::class, 'genres']);
        Route::get('list', [UserMovieController::class, 'list']);
        Route::get('', [UserMovieController::class, 'get']);
        Route::post('watch', [UserMovieController::class, 'watch']);
        Route::post('favorite', [UserFavoriteMovieController::class, 'addToFavorite']);
        Route::get('favorite', [UserFavoriteMovieController::class, 'getUserFavoriteMovies']);
        Route::delete('favorite', [UserFavoriteMovieController::class, 'removeUserFavoriteMovies']);
    });

    Route::post('rent/pay', [UserPaymentController::class, 'payRent']);
    Route::post('subscription/pay', [UserPaymentController::class, 'paySubscription']);
    Route::post('verify', [UserPaymentController::class, 'verify']);
});
