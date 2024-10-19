<?php

namespace App\Providers;

use App\Contracts\Repositories\Eloquent\Movie\MovieRepository;
use App\Modules\Movie\Models\Movie;
use App\Modules\Movie\Services\MovieSearchService\OMDBMovieSearchService;
use App\Modules\Movie\Services\MovieService\MovieService;
use App\Modules\Movie\Services\MovieStatusService\MovieStatusService;
use App\Modules\Movie\Services\VideoUploader\VideoUploaderService;
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

        $this->app->bind(VideoUploaderService::class, function ($app) {
            $movieRepository = new MovieRepository(new Movie());

            return new VideoUploaderService($movieRepository);
        });

        $this->app->bind(MovieStatusService::class, function ($app) {
            $movieRepository = new MovieRepository(new Movie());

            return new MovieStatusService($movieRepository);
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
