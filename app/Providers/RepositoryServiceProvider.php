<?php

namespace App\Providers;

use App\Contracts\Repositories\Eloquent\Movie\MovieRepository;
use App\Contracts\Repositories\IMovieRepository;
use App\Models\Movie;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IMovieRepository::class, function ($app) {
            $movieEloquent = new Movie();

            return new MovieRepository($movieEloquent);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
