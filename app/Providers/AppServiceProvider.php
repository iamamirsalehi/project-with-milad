<?php

namespace App\Providers;

use App\Contracts\Repositories\Eloquent\MovieRepository;
use App\Modules\Movie\Models\Movie;
use App\Modules\Movie\Services\MovieSearchService\OMDBMovieSearchService;
use App\Modules\Movie\Services\MovieService\MovieService;
use App\Modules\Movie\Services\VideoUploader\HttpVideoUploaderService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MovieService::class, function ($app) {
            $apiKey = config('services.omdb.api-key');

            $omdbDataProvider = new OMDBMovieSearchService($apiKey);

            $movieRepository = new MovieRepository(new Movie());

            return new MovieService($omdbDataProvider, $movieRepository);
        });

        $this->app->bind(HttpVideoUploaderService::class, function ($app) {
            $movieRepository = new MovieRepository(new Movie());

            return new HttpVideoUploaderService($movieRepository);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
