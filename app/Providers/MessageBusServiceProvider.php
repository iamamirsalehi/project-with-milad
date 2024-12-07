<?php

namespace App\Providers;

use App\Src\Application\Command\FavouriteMovie\AddFavouriteMovieCommand;
use App\Src\Application\Command\FavouriteMovie\GetUserFavouriteMovieCommand;
use App\Src\Application\Command\FavouriteMovie\RemoveFavouriteMovieCommand;
use App\Src\Application\Command\Genre\AllGenreCommand;
use App\Src\Application\Command\Movie\AddMovieCommand;
use App\Src\Application\Command\Movie\DraftMovieCommand;
use App\Src\Application\Command\Movie\FilterMovieCommand;
use App\Src\Application\Command\Movie\GetMovieCommand;
use App\Src\Application\Command\Movie\GetMovieIfAvailableCommand;
use App\Src\Application\Command\Movie\PublishMovieCommand;
use App\Src\Application\Command\Movie\UploadVideoCommand;
use App\Src\Application\Command\Movie\WatchMovieCommand;
use App\Src\Application\Command\MovieRent\ActivateMovieRentCommand;
use App\Src\Application\Command\Payment\PayRentCommand;
use App\Src\Application\Command\Payment\PaySubscriptionCommand;
use App\Src\Application\Command\Payment\VerifyPaymentCommand;
use App\Src\Application\Command\Subscription\AddSubscriptionCommand;
use App\Src\Application\CommandHandler\FavouriteMovie\AddFavouriteMovieCommandHandler;
use App\Src\Application\CommandHandler\FavouriteMovie\GetUserFavouriteMovieCommandHandler;
use App\Src\Application\CommandHandler\FavouriteMovie\RemoveFavouriteMovieCommandHandler;
use App\Src\Application\CommandHandler\Genre\AllGenreCommandHandler;
use App\Src\Application\CommandHandler\Movie\AddMovieCommandHandler;
use App\Src\Application\CommandHandler\Movie\DraftMovieCommandHandler;
use App\Src\Application\CommandHandler\Movie\FilterMovieCommandHandler;
use App\Src\Application\CommandHandler\Movie\GetMovieCommandHandler;
use App\Src\Application\CommandHandler\Movie\GetMovieIfAvailableCommandHandler;
use App\Src\Application\CommandHandler\Movie\PublishMovieCommandHandler;
use App\Src\Application\CommandHandler\Movie\UploadVideoCommandHandler;
use App\Src\Application\CommandHandler\Movie\WatchMovieCommandHandler;
use App\Src\Application\CommandHandler\MovieRent\ActivateMovieRentCommandHandler;
use App\Src\Application\CommandHandler\Payment\PayRentCommandHandler;
use App\Src\Application\CommandHandler\Payment\PaySubscriptionCommandHandler;
use App\Src\Application\CommandHandler\Payment\VerifyPaymentCommandHandler;
use App\Src\Application\CommandHandler\Subscription\AddSubscriptionCommandHandler;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Messenger\Handler\HandlerDescriptor;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

class MessageBusServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(MessageBusInterface::class, function ($app) {
            return new MessageBus([
                new HandleMessageMiddleware(
                    new HandlersLocator(
                        array_merge(
                            $this->getFavouriteMovieCommands($app),
                            $this->getGenreCommands($app),
                            $this->getMovieCommands($app),
                            $this->getMovieRentCommands($app),
                            $this->getPaymentCommands($app),
                            $this->getSubscriptionCommands($app),
                        ),
                    )
                ),
            ]);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    private function getFavouriteMovieCommands(App $app): array
    {
        return [
            AddFavouriteMovieCommand::class => [
                new HandlerDescriptor($app->make(AddFavouriteMovieCommandHandler::class)),
            ],
            RemoveFavouriteMovieCommand::class => [
                new HandlerDescriptor($app->make(RemoveFavouriteMovieCommandHandler::class)),
            ],
            GetUserFavouriteMovieCommand::class => [
                new HandlerDescriptor($app->make(GetUserFavouriteMovieCommandHandler::class)),
            ],
        ];
    }

    private function getGenreCommands(App $app): array
    {
        return [
            AllGenreCommand::class => [
                new HandlerDescriptor($app->make(AllGenreCommandHandler::class)),
            ]
        ];
    }

    private function getMovieCommands(App $app): array
    {
        return [
            AddMovieCommand::class => [
                new HandlerDescriptor($app->make(AddMovieCommandHandler::class)),
            ],
            DraftMovieCommand::class => [
                new HandlerDescriptor($app->make(DraftMovieCommandHandler::class)),
            ],
            FilterMovieCommand::class => [
                new HandlerDescriptor($app->make(FilterMovieCommandHandler::class)),
            ],
            GetMovieCommand::class => [
                new HandlerDescriptor($app->make(GetMovieCommandHandler::class)),
            ],
            GetMovieIfAvailableCommand::class => [
                new HandlerDescriptor($app->make(GetMovieIfAvailableCommandHandler::class)),
            ],
            PublishMovieCommand::class => [
                new HandlerDescriptor($app->make(PublishMovieCommandHandler::class)),
            ],
            UploadVideoCommand::class => [
                new HandlerDescriptor($app->make(UploadVideoCommandHandler::class)),
            ],
            WatchMovieCommand::class => [
                new HandlerDescriptor($app->make(WatchMovieCommandHandler::class)),
            ],
        ];
    }

    private function getMovieRentCommands(App $app): array
    {
        return [
            ActivateMovieRentCommand::class => [
                new HandlerDescriptor($app->make(ActivateMovieRentCommandHandler::class)),
            ],
        ];
    }

    private function getPaymentCommands(App $app): array
    {
        return [
            PayRentCommand::class => [
                new HandlerDescriptor($app->make(PayRentCommandHandler::class)),
            ],
            PaySubscriptionCommand::class => [
                new HandlerDescriptor($app->make(PaySubscriptionCommandHandler::class))
            ],
            VerifyPaymentCommand::class => [
                new HandlerDescriptor($app->make(VerifyPaymentCommandHandler::class))
            ],
        ];
    }

    private function getSubscriptionCommands(App $app): array
    {
        return [
            AddSubscriptionCommand::class => [
                new HandlerDescriptor($app->make(AddSubscriptionCommandHandler::class)),
            ],
        ];
    }
}
