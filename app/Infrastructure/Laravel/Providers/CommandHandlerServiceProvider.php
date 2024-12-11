<?php

namespace App\Infrastructure\Laravel\Providers;

use App\Application\CommandHandler\ActivateMovieRentCommandHandler;
use App\Application\CommandHandler\AddFavouriteMovieCommandHandler;
use App\Application\CommandHandler\AddMovieCommandHandler;
use App\Application\CommandHandler\AddSubscriptionCommandHandler;
use App\Application\CommandHandler\DraftMovieCommandHandler;
use App\Application\CommandHandler\PayRentCommandHandler;
use App\Application\CommandHandler\PublishMovieCommandHandler;
use App\Application\CommandHandler\RemoveFavouriteMovieCommandHandler;
use App\Application\CommandHandler\UploadVideoCommandHandler;
use App\Application\CommandHandler\WatchMovieCommandHandler;
use App\Application\QueryHandler\AllGenreQueryHandler;
use App\Application\QueryHandler\FilterMovieQueryHandler;
use App\Application\QueryHandler\GetMovieIfAvailableQueryHandler;
use App\Application\QueryHandler\GetMovieQueryHandler;
use App\Application\QueryHandler\GetUserFavouriteMovieQueryHandler;
use App\Application\Service\MovieRentService\MovieRentService;
use App\Application\Service\MovieSearchService\IMovieSearchService;
use App\Application\Service\PaymentService\PaymentService;
use App\Domain\Repository\FavoriteRepository;
use App\Domain\Repository\GenreRepository;
use App\Domain\Repository\MovieGenreRepository;
use App\Domain\Repository\MovieRentRepository;
use App\Domain\Repository\MovieRepository;
use App\Domain\Repository\SubscriptionRepository;
use App\Domain\Repository\Transaction;
use App\Domain\Repository\UserSubscriptionRepository;
use App\Domain\Service\MovieRentPriceCalculation\MovieRentPriceCalculation;
use App\Domain\Service\VideoUploader\VideoUploader;
use App\Infrastructure\MessageBus\MessageBus;
use Illuminate\Support\ServiceProvider;

class CommandHandlerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(AddFavouriteMovieCommandHandler::class, function ($app) {
            return new AddFavouriteMovieCommandHandler(
                $app->make(MovieRepository::class),
                $app->make(FavoriteRepository::class),
                $app->make(MessageBus::class),
            );
        });

        $this->app->singleton(GetUserFavouriteMovieQueryHandler::class, function ($app) {
            return new GetUserFavouriteMovieQueryHandler(
                $app->make(FavoriteRepository::class),
            );
        });

        $this->app->singleton(RemoveFavouriteMovieCommandHandler::class, function ($app) {
            return new RemoveFavouriteMovieCommandHandler(
                $app->make(MovieRepository::class),
                $app->make(FavoriteRepository::class),
            );
        });

        $this->app->singleton(AllGenreQueryHandler::class, function ($app) {
            return new AllGenreQueryHandler(
                $app->make(GenreRepository::class),
            );
        });

        $this->app->singleton(AddMovieCommandHandler::class, function ($app) {
            return new AddMovieCommandHandler(
                $app->make(MovieRepository::class),
                $app->make(MovieGenreRepository::class),
                $app->make(GenreRepository::class),
                $app->make(IMovieSearchService::class),
                $app->make(Transaction::class)
            );
        });

        $this->app->singleton(DraftMovieCommandHandler::class, function ($app) {
            return new DraftMovieCommandHandler(
                $app->make(MovieRepository::class),
            );
        });

        $this->app->singleton(FilterMovieQueryHandler::class, function ($app) {
            return new FilterMovieQueryHandler(
                $app->make(GenreRepository::class),
                $app->make(MovieRepository::class),
            );
        });

        $this->app->singleton(GetMovieQueryHandler::class, function ($app) {
            return new GetMovieQueryHandler(
                $app->make(MovieRepository::class),
            );
        });

        $this->app->singleton(GetMovieIfAvailableQueryHandler::class, function ($app) {
            return new GetMovieIfAvailableQueryHandler(
                $app->make(MovieRepository::class),
            );
        });

        $this->app->singleton(PublishMovieCommandHandler::class, function ($app) {
            return new PublishMovieCommandHandler(
                $app->make(MovieRepository::class),
            );
        });

        $this->app->singleton(UploadVideoCommandHandler::class, function ($app) {
            return new UploadVideoCommandHandler(
                $app->make(MovieRepository::class),
                $app->make(VideoUploader::class),
            );
        });

        $this->app->singleton(WatchMovieCommandHandler::class, function ($app) {
            return new WatchMovieCommandHandler(
                $app->make(MovieRepository::class),
                $app->make(MovieRentRepository::class),
                $app->make(UserSubscriptionRepository::class),
            );
        });

        $this->app->singleton(ActivateMovieRentCommandHandler::class, function ($app) {
            return new ActivateMovieRentCommandHandler(
                $app->make(MovieRentRepository::class),
            );
        });

        $this->app->singleton(PayRentCommandHandler::class, function ($app) {
            return new PayRentCommandHandler(
                $app->make(MovieRepository::class),
                $app->make(MovieRentService::class),
                $app->make(MovieRentPriceCalculation::class),
                $app->make(PaymentService::class),
            );
        });

        $this->app->singleton(AddSubscriptionCommandHandler::class, function ($app) {
            return new AddSubscriptionCommandHandler(
                $app->make(SubscriptionRepository::class),
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
