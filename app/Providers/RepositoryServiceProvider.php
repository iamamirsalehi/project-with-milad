<?php

namespace App\Providers;

use App\Src\Domain\Model\Favorite\FavoriteMovie;
use App\Src\Domain\Model\Movie\Genre;
use App\Src\Domain\Model\Movie\Movie;
use App\Src\Domain\Model\Movie\MovieGenre;
use App\Src\Domain\Model\Movie\MovieRent;
use App\Src\Domain\Model\Payment\Payment;
use App\Src\Domain\Model\Subscription\Subscription;
use App\Src\Domain\Model\Subscription\UserSubscription;
use App\Src\Domain\Model\User\User;
use App\Src\Domain\Repository\IFavoriteRepository;
use App\Src\Domain\Repository\IGenreRepository;
use App\Src\Domain\Repository\IMovieGenreRepository;
use App\Src\Domain\Repository\IMovieRentRepository;
use App\Src\Domain\Repository\IMovieRepository;
use App\Src\Domain\Repository\IPaymentRepository;
use App\Src\Domain\Repository\ISubscriptionRepository;
use App\Src\Domain\Repository\ITransaction;
use App\Src\Domain\Repository\IUserRepository;
use App\Src\Domain\Repository\IUserSubscriptionRepository;
use App\Src\Instrastructure\Persistance\Repository\Eloquent\FavoriteRepository;
use App\Src\Instrastructure\Persistance\Repository\Eloquent\GenreRepository;
use App\Src\Instrastructure\Persistance\Repository\Eloquent\MovieGenreRepository;
use App\Src\Instrastructure\Persistance\Repository\Eloquent\MovieRentRepository;
use App\Src\Instrastructure\Persistance\Repository\Eloquent\MovieRepository;
use App\Src\Instrastructure\Persistance\Repository\Eloquent\PaymentRepository;
use App\Src\Instrastructure\Persistance\Repository\Eloquent\SubscriptionRepository;
use App\Src\Instrastructure\Persistance\Repository\Eloquent\Transaction;
use App\Src\Instrastructure\Persistance\Repository\Eloquent\UserRepository;
use App\Src\Instrastructure\Persistance\Repository\Eloquent\UserSubscriptionRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IMovieRepository::class, function ($app) {
            $movieEloquent = new Movie();

            return new MovieRepository($movieEloquent);
        });

        $this->app->bind(ISubscriptionRepository::class, function ($app) {
            $subscriptionEloquent = new Subscription();

            return new SubscriptionRepository($subscriptionEloquent);
        });

        $this->app->bind(IUserSubscriptionRepository::class, function ($app) {
            $userSubscriptionEloquent = new UserSubscription();

            return new UserSubscriptionRepository($userSubscriptionEloquent);
        });

        $this->app->bind(IFavoriteRepository::class, function ($app) {
            $favoriteEloquent = new FavoriteMovie();

            return new FavoriteRepository($favoriteEloquent);
        });

        $this->app->bind(IPaymentRepository::class, function ($app) {
            $paymentEloquent = new Payment();

            return new PaymentRepository($paymentEloquent);
        });

        $this->app->bind(IUserRepository::class, function ($app) {
            $userEloquent = new User();

            return new UserRepository($userEloquent);
        });

        $this->app->bind(IMovieRentRepository::class, function ($app) {
            $movieRentEloquent = new MovieRent();

            return new MovieRentRepository($movieRentEloquent);
        });

        $this->app->bind(IGenreRepository::class, function ($app) {
            $genreEloquent = new Genre();

            return new GenreRepository($genreEloquent);
        });

        $this->app->bind(IMovieGenreRepository::class, function ($app) {
            $movieGenreEloquent = new MovieGenre();

            return new MovieGenreRepository($movieGenreEloquent);
        });

        $this->app->bind(ITransaction::class, Transaction::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
