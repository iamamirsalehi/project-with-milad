<?php

namespace App\Providers;

use App\Src\Application\Command\FavouriteMovie\AddFavouriteMovieCommand;
use App\Src\Application\Command\FavouriteMovie\GetUserFavouriteMovieCommand;
use App\Src\Application\Command\FavouriteMovie\RemoveFavouriteMovieCommand;
use App\Src\Application\Command\Movie\AddMovieCommand;
use App\Src\Application\CommandHandler\FavouriteMovie\AddFavouriteMovieCommandHandler;
use App\Src\Application\CommandHandler\FavouriteMovie\GetUserFavouriteMovieCommandHandler;
use App\Src\Application\CommandHandler\FavouriteMovie\RemoveFavouriteMovieCommandHandler;
use App\Src\Application\CommandHandler\Movie\AddMovieCommandHandler;
use App\Src\Application\Service\MovieSearchService\OMDBMovieSearchService;
use App\Src\Application\Service\PaymentService\PaymentRegistry;
use App\Src\Domain\Repository\IFavoriteRepository;
use App\Src\Domain\Repository\IGenreRepository;
use App\Src\Domain\Repository\IMovieGenreRepository;
use App\Src\Domain\Repository\IMovieRepository;
use App\Src\Domain\Repository\ITransaction;
use App\Src\Domain\Service\Payment\IPaymentMethod;
use App\Src\Domain\Service\VideoUploader\IVideoUploader;
use App\Src\Instrastructure\MessageBus\IMessageBus;
use App\Src\Instrastructure\MessageBus\RedisMessageBus;
use App\Src\Instrastructure\Resolver\IResolver;
use App\Src\Instrastructure\Resolver\LaravelResolver;
use App\Src\Instrastructure\Service\PaymentMethods\MellatPayment;
use App\Src\Instrastructure\Service\PaymentMethods\SamanPayment;
use App\Src\Instrastructure\Service\VideoUploader\LocalStorageUploader;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Messenger\Handler\HandlerDescriptor;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AddMovieCommandHandler::class, function ($app) {
            $apiKey = config('services.omdb.api-key');
            $omdbDataProvider = new OMDBMovieSearchService($apiKey);

            return new AddMovieCommandHandler(
                $app->make(IMovieRepository::class),
                $app->make(IMovieGenreRepository::class),
                $app->make(IGenreRepository::class),
                $omdbDataProvider,
                $app->make(ITransaction::class)
            );
        });

        $this->app->singleton(AddFavouriteMovieCommandHandler::class, function ($app) {
            return new AddFavouriteMovieCommandHandler(
                $app->make(IMovieRepository::class),
                $app->make(IFavoriteRepository::class),
                $app->make(IMessageBus::class),
            );
        });

        $this->app->singleton(MessageBusInterface::class, function ($app) {
            return new MessageBus([
                new HandleMessageMiddleware(
                    new HandlersLocator([
                        AddMovieCommand::class => [
                            new HandlerDescriptor($app->make(AddMovieCommandHandler::class)),
                        ],
                        AddFavouriteMovieCommand::class => [
                            new HandlerDescriptor($app->make(AddFavouriteMovieCommandHandler::class)),
                        ],
                        RemoveFavouriteMovieCommand::class => [
                            new HandlerDescriptor($app->make(RemoveFavouriteMovieCommandHandler::class)),
                        ],
                        GetUserFavouriteMovieCommand::class => [
                            new HandlerDescriptor($app->make(GetUserFavouriteMovieCommandHandler::class)),
                        ],
                    ])
                ),
            ]);
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
