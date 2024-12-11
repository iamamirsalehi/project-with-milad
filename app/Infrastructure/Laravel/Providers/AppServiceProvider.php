<?php

namespace App\Infrastructure\Laravel\Providers;

use App\Application\Service\MovieSearchService\IMovieSearchService;
use App\Application\Service\MovieSearchService\OMDBMovieSearchService;
use App\Application\Service\PaymentService\PaymentRegistry;
use App\Domain\Resolver\Resolver;
use App\Domain\Service\VideoUploader\VideoUploader;
use App\Infrastructure\MessageBus\MessageBus;
use App\Infrastructure\MessageBus\RedisMessageBus;
use App\Infrastructure\Resolver\LaravelResolver;
use App\Infrastructure\Service\PaymentMethods\MellatPayment;
use App\Infrastructure\Service\PaymentMethods\SamanPayment;
use App\Infrastructure\Service\VideoUploader\LocalStorageUploader;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(IMovieSearchService::class, function ($app) {
            $apiKey = config('services.omdb.api-key');
            return new OMDBMovieSearchService($apiKey);
        });
        $this->app->singleton(MessageBus::class, RedisMessageBus::class);
        $this->app->singleton(VideoUploader::class, LocalStorageUploader::class);
        $this->app->singleton(Resolver::class, function ($app) {
            return new LaravelResolver($app);
        });
        $this->app->tag([SamanPayment::class, MellatPayment::class], 'payment-gateways');
        $this->app->singleton(PaymentRegistry::class, function ($app) {
            $gateways = $app->tagged('payment-gateways');

            return new PaymentRegistry($app->make(Resolver::class), $gateways);
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
