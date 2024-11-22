<?php

namespace App\Providers;

use App\Contracts\MessageBus\IMessageBus;
use App\Contracts\MessageBus\RedisMessageBus;
use App\Contracts\Repositories\Eloquent\GenreRepository;
use App\Contracts\Repositories\Eloquent\MovieGenreRepository;
use App\Contracts\Repositories\Eloquent\MovieRentRepository;
use App\Contracts\Repositories\Eloquent\MovieRepository;
use App\Contracts\Repositories\Eloquent\SubscriptionRepository;
use App\Contracts\Repositories\Eloquent\UserSubscriptionRepository;
use App\Contracts\Resolver\IResolver;
use App\Contracts\Resolver\LaravelResolver;
use App\Modules\Movie\Models\Genre;
use App\Modules\Movie\Models\Movie;
use App\Modules\Movie\Models\MovieGenre;
use App\Modules\Movie\Models\MovieRent;
use App\Modules\Movie\Services\MovieGenreService\MovieGenreService;
use App\Modules\Movie\Services\MovieSearchService\OMDBMovieSearchService;
use App\Modules\Movie\Services\MovieService\MovieService;
use App\Modules\Movie\Services\VideoUploader\IVideoUploader;
use App\Modules\Movie\Services\VideoUploader\LocalStorageUploader;
use App\Modules\Movie\Services\VideoUploader\VideoUploaderService;
use App\Modules\Payment\Enums\PaymentMethod;
use App\Modules\Payment\Services\PaymentProviders\IPaymentMethod;
use App\Modules\Payment\Services\PaymentProviders\PaymentMethods\MellatPayment;
use App\Modules\Payment\Services\PaymentProviders\PaymentMethods\SamanPayment;
use App\Modules\Payment\Services\PaymentProviders\PaymentRegistry;
use App\Modules\Subscription\Models\Subscription;
use App\Modules\Subscription\Models\UserSubscription;
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

            $genreRepository = new GenreRepository(new Genre());

            $movieGenreRepository = new MovieGenreRepository(new MovieGenre());;

            $movieGenreService = new MovieGenreService($movieRepository, $genreRepository, $movieGenreRepository);

            $userSubscriptionRepository = new UserSubscriptionRepository(new UserSubscription());

            $movieRentRepository = new MovieRentRepository(new MovieRent());

            $genreRepository = new GenreRepository(new Genre());

            return new MovieService(
                $omdbDataProvider,
                $movieRepository,
                $movieGenreService,
                $userSubscriptionRepository,
                $movieRentRepository,
                $genreRepository
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
            $register = new PaymentRegistry($app->make(IResolver::class));

            $register->register(PaymentMethod::Saman, SamanPayment::class);
            $register->register(PaymentMethod::Mellat, MellatPayment::class);

            return $register;
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
