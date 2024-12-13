<?php

namespace App\Infrastructure\Laravel\Providers;

use App\Application\Command\ActivateMovieRentCommand;
use App\Application\Command\AddFavouriteMovieCommand;
use App\Application\Command\AddMovieCommand;
use App\Application\Command\AddSubscriptionCommand;
use App\Application\Command\DraftMovieCommand;
use App\Application\Command\PayRentCommand;
use App\Application\Command\PaySubscriptionCommand;
use App\Application\Command\PublishMovieCommand;
use App\Application\Command\RemoveFavouriteMovieCommand;
use App\Application\Command\UploadVideoCommand;
use App\Application\Command\VerifyPaymentCommand;
use App\Application\Command\WatchMovieCommand;
use App\Application\CommandHandler\ActivateMovieRentCommandHandler;
use App\Application\CommandHandler\AddFavouriteMovieCommandHandler;
use App\Application\CommandHandler\AddMovieCommandHandler;
use App\Application\CommandHandler\AddSubscriptionCommandHandler;
use App\Application\CommandHandler\DraftMovieCommandHandler;
use App\Application\CommandHandler\PayRentCommandHandler;
use App\Application\CommandHandler\PaySubscriptionCommandHandler;
use App\Application\CommandHandler\PublishMovieCommandHandler;
use App\Application\CommandHandler\RemoveFavouriteMovieCommandHandler;
use App\Application\CommandHandler\UploadVideoCommandHandler;
use App\Application\CommandHandler\VerifyPaymentCommandHandler;
use App\Application\CommandHandler\WatchMovieCommandHandler;
use App\Application\Query\AllGenreQuery;
use App\Application\Query\FilterMovieQuery;
use App\Application\Query\GetMovieAccessLink;
use App\Application\Query\GetMovieIfAvailableQuery;
use App\Application\Query\GetMovieQuery;
use App\Application\Query\GetUserFavouriteMovieQuery;
use App\Application\QueryHandler\AllGenreQueryHandler;
use App\Application\QueryHandler\FilterMovieQueryHandler;
use App\Application\QueryHandler\GetMovieAccessLinkQueryHandler;
use App\Application\QueryHandler\GetMovieIfAvailableQueryHandler;
use App\Application\QueryHandler\GetMovieQueryHandler;
use App\Application\QueryHandler\GetUserFavouriteMovieQueryHandler;
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
            GetUserFavouriteMovieQuery::class => [
                new HandlerDescriptor($app->make(GetUserFavouriteMovieQueryHandler::class)),
            ],
        ];
    }

    private function getGenreCommands(App $app): array
    {
        return [
            AllGenreQuery::class => [
                new HandlerDescriptor($app->make(AllGenreQueryHandler::class)),
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
            FilterMovieQuery::class => [
                new HandlerDescriptor($app->make(FilterMovieQueryHandler::class)),
            ],
            GetMovieQuery::class => [
                new HandlerDescriptor($app->make(GetMovieQueryHandler::class)),
            ],
            GetMovieIfAvailableQuery::class => [
                new HandlerDescriptor($app->make(GetMovieIfAvailableQueryHandler::class)),
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
            GetMovieAccessLink::class => [
                new HandlerDescriptor($app->make(GetMovieAccessLinkQueryHandler::class)),
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
