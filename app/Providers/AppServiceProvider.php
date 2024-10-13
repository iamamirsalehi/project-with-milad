<?php

namespace App\Providers;

use App\Services\MovieDataProvider\MovieDataProviderInterface;
use App\Services\MovieDataProvider\OMDBDataProviderService;
use App\Services\MovieSearch\MovieSearchInterface;
use App\Services\MovieSearch\MovieSearchService;
use App\Services\VideoUploader\VideoUploaderService;
use App\Services\VideoUploader\VideoUploaderServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MovieSearchInterface::class, function ($app) {
            $apiKey = config('services.omdb.api-key');

            $omdbDataProvider = new OMDBDataProviderService($apiKey);

            return new MovieSearchService($omdbDataProvider);
        });

        $this->app->bind(VideoUploaderServiceInterface::class, function ($app) {
            return new VideoUploaderService();
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
