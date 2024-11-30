<?php

namespace App\Providers;

use App\Contracts\MessageBus\IMessageBus;
use App\Contracts\MessageBus\RedisMessageBus;
use App\Contracts\Repositories\Eloquent\MovieRepository;
use App\Contracts\Repositories\IGenreRepository;
use App\Contracts\Repositories\IMovieGenreRepository;
use App\Contracts\Repositories\IMovieRentRepository;
use App\Contracts\Repositories\IMovieRepository;
use App\Contracts\Repositories\IUserSubscriptionRepository;
use App\Contracts\Resolver\IResolver;
use App\Contracts\Resolver\LaravelResolver;
use App\Modules\Movie\Models\Movie;
use App\Modules\Movie\Services\MovieSearchService\OMDBMovieSearchService;
use App\Modules\Movie\Services\MovieService\MovieService;
use App\Modules\Movie\Services\VideoUploader\IVideoUploader;
use App\Modules\Movie\Services\VideoUploader\LocalStorageUploader;
use App\Modules\Movie\Services\VideoUploader\VideoUploaderService;
use App\Modules\Payment\Services\PaymentProviders\IPaymentMethod;
use App\Modules\Payment\Services\PaymentProviders\PaymentMethods\MellatPayment;
use App\Modules\Payment\Services\PaymentProviders\PaymentMethods\SamanPayment;
use App\Modules\Payment\Services\PaymentProviders\PaymentRegistry;
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

            $movieRepository = $app->make(IMovieRepository::class);
            $movieGenreRepository = $app->make(IMovieGenreRepository::class);;
            $userSubscriptionRepository = $app->make(IUserSubscriptionRepository::class);
            $movieRentRepository = $app->make(IMovieRentRepository::class);
            $genreRepository = $app->make(IGenreRepository::class);

            return new MovieService(
                $omdbDataProvider,
                $movieRepository,
                $userSubscriptionRepository,
                $movieRentRepository,
                $genreRepository,
                $movieGenreRepository
            );
        });

        $this->app->bind(VideoUploaderService::class, function ($app) {
            $movieRepository = new MovieRepository(new Movie());
            $videoUploaderService = new LocalStorageUploader();

            return new VideoUploaderService($movieRepository, $videoUploaderService);
        });

        $this->app->bind(IPaymentMethod::class, function ($app) {
            return new SamanPayment();
        });

        $this->app->bind(IMessageBus::class, RedisMessageBus::class);

        $this->app->bind(IVideoUploader::class, LocalStorageUploader::class);

        $this->app->singleton(IResolver::class, function ($app) {
            return new LaravelResolver($app);
        });

        $this->app->singleton(PaymentRegistry::class, function ($app) {
            $gateways = [
                SamanPayment::class,
                MellatPayment::class,
            ];

            return new PaymentRegistry($app->make(IResolver::class), $gateways);
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
