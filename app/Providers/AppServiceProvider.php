<?php

namespace App\Providers;

use App\Contracts\MessageBus\IMessageBus;
use App\Contracts\MessageBus\RedisMessageBus;
use App\Contracts\Repositories\Eloquent\MovieRepository;
use App\Modules\Movie\Models\Movie;
use App\Modules\Movie\Services\MovieSearchService\OMDBMovieSearchService;
use App\Modules\Movie\Services\MovieService\MovieService;
use App\Modules\Movie\Services\VideoUploader\IVideoUploader;
use App\Modules\Movie\Services\VideoUploader\LocalStorageUploader;
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
            $videoUploaderService = new LocalStorageUploader();

            return new VideoUploaderService($movieRepository, $videoUploaderService);
        });

        $this->app->bind(IMessageBus::class, RedisMessageBus::class);
        $this->app->bind(IVideoUploader::class, LocalStorageUploader::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
