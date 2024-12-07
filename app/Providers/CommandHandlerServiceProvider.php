<?php

namespace App\Providers;

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
use App\Src\Application\CommandHandler\Subscription\AddSubscriptionCommandHandler;
use App\Src\Application\Service\MovieRentService\MovieRentService;
use App\Src\Application\Service\MovieSearchService\IMovieSearchService;
use App\Src\Application\Service\PaymentService\PaymentService;
use App\Src\Domain\Repository\IFavoriteRepository;
use App\Src\Domain\Repository\IGenreRepository;
use App\Src\Domain\Repository\IMovieGenreRepository;
use App\Src\Domain\Repository\IMovieRentRepository;
use App\Src\Domain\Repository\IMovieRepository;
use App\Src\Domain\Repository\ISubscriptionRepository;
use App\Src\Domain\Repository\ITransaction;
use App\Src\Domain\Repository\IUserSubscriptionRepository;
use App\Src\Domain\Service\MovieRentPriceCalculation\MovieRentPriceCalculation;
use App\Src\Domain\Service\VideoUploader\IVideoUploader;
use App\Src\Instrastructure\MessageBus\IMessageBus;
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
                $app->make(IMovieRepository::class),
                $app->make(IFavoriteRepository::class),
                $app->make(IMessageBus::class),
            );
        });

        $this->app->singleton(GetUserFavouriteMovieCommandHandler::class, function ($app) {
            return new GetUserFavouriteMovieCommandHandler(
                $app->make(IFavoriteRepository::class),
            );
        });

        $this->app->singleton(RemoveFavouriteMovieCommandHandler::class, function ($app) {
            return new RemoveFavouriteMovieCommandHandler(
                $app->make(IMovieRepository::class),
                $app->make(IFavoriteRepository::class),
            );
        });

        $this->app->singleton(AllGenreCommandHandler::class, function ($app) {
            return new AllGenreCommandHandler(
                $app->make(IGenreRepository::class),
            );
        });

        $this->app->singleton(AddMovieCommandHandler::class, function ($app) {
            return new AddMovieCommandHandler(
                $app->make(IMovieRepository::class),
                $app->make(IMovieGenreRepository::class),
                $app->make(IGenreRepository::class),
                $app->make(IMovieSearchService::class),
                $app->make(ITransaction::class)
            );
        });

        $this->app->singleton(DraftMovieCommandHandler::class, function ($app) {
            return new DraftMovieCommandHandler(
                $app->make(IMovieRepository::class),
            );
        });

        $this->app->singleton(FilterMovieCommandHandler::class, function ($app) {
            return new FilterMovieCommandHandler(
                $app->make(IGenreRepository::class),
                $app->make(IMovieRepository::class),
            );
        });

        $this->app->singleton(GetMovieCommandHandler::class, function ($app) {
            return new GetMovieCommandHandler(
                $app->make(IMovieRepository::class),
            );
        });

        $this->app->singleton(GetMovieIfAvailableCommandHandler::class, function ($app) {
            return new GetMovieIfAvailableCommandHandler(
                $app->make(IMovieRepository::class),
            );
        });

        $this->app->singleton(PublishMovieCommandHandler::class, function ($app) {
            return new PublishMovieCommandHandler(
                $app->make(IMovieRepository::class),
            );
        });

        $this->app->singleton(UploadVideoCommandHandler::class, function ($app) {
            return new UploadVideoCommandHandler(
                $app->make(IMovieRepository::class),
                $app->make(IVideoUploader::class),
            );
        });

        $this->app->singleton(WatchMovieCommandHandler::class, function ($app) {
            return new WatchMovieCommandHandler(
                $app->make(IMovieRepository::class),
                $app->make(IMovieRentRepository::class),
                $app->make(IUserSubscriptionRepository::class),
            );
        });

        $this->app->singleton(ActivateMovieRentCommandHandler::class, function ($app) {
            return new ActivateMovieRentCommandHandler(
                $app->make(IMovieRentRepository::class),
            );
        });

        $this->app->singleton(PayRentCommandHandler::class, function ($app) {
            return new PayRentCommandHandler(
                $app->make(IMovieRepository::class),
                $app->make(MovieRentService::class),
                $app->make(MovieRentPriceCalculation::class),
                $app->make(PaymentService::class),
            );
        });

        $this->app->singleton(AddSubscriptionCommandHandler::class, function ($app) {
            return new AddSubscriptionCommandHandler(
                $app->make(ISubscriptionRepository::class),
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
