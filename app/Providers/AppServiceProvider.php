<?php

namespace App\Providers;

use App\Src\Application\Service\MovieSearchService\IMovieSearchService;
use App\Src\Application\Service\MovieSearchService\OMDBMovieSearchService;
use App\Src\Application\Service\PaymentService\PaymentRegistry;
use App\Src\Domain\Resolver\IResolver;
use App\Src\Domain\Service\VideoUploader\IVideoUploader;
use App\Src\Instrastructure\MessageBus\IMessageBus;
use App\Src\Instrastructure\MessageBus\RedisMessageBus;
use App\Src\Instrastructure\Resolver\LaravelResolver;
use App\Src\Instrastructure\Service\PaymentMethods\MellatPayment;
use App\Src\Instrastructure\Service\PaymentMethods\SamanPayment;
use App\Src\Instrastructure\Service\VideoUploader\LocalStorageUploader;
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
        $this->app->singleton(IMessageBus::class, RedisMessageBus::class);
        $this->app->singleton(IVideoUploader::class, LocalStorageUploader::class);
        $this->app->singleton(IResolver::class, function ($app) {
            return new LaravelResolver($app);
        });
        $this->app->tag([SamanPayment::class, MellatPayment::class], 'payment-gateways');
        $this->app->singleton(PaymentRegistry::class, function ($app) {
            $gateways = $app->tagged('payment-gateways');

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
