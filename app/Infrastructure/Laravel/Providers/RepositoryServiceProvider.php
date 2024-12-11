<?php

namespace App\Infrastructure\Laravel\Providers;

use App\Domain\Model\Favorite\FavoriteMovie;
use App\Domain\Model\Movie\Genre;
use App\Domain\Model\Movie\Movie;
use App\Domain\Model\Movie\MovieGenre;
use App\Domain\Model\Movie\MovieRent;
use App\Domain\Model\Payment\Payment;
use App\Domain\Model\Subscription\Subscription;
use App\Domain\Model\Subscription\UserSubscription;
use App\Domain\Model\User\User;
use App\Domain\Repository\GenreRepository;
use App\Domain\Repository\MovieGenreRepository;
use App\Domain\Repository\MovieRentRepository;
use App\Domain\Repository\MovieRepository;
use App\Domain\Repository\PaymentRepository;
use App\Domain\Repository\SubscriptionRepository;
use App\Domain\Repository\Transaction;
use App\Domain\Repository\UserRepository;
use App\Domain\Repository\UserSubscriptionRepository;
use App\Infrastructure\Persistance\Repository\Eloquent\EloquentFavoriteRepository;
use App\Infrastructure\Persistance\Repository\Eloquent\EloquentGenreRepository;
use App\Infrastructure\Persistance\Repository\Eloquent\EloquentMovieGenreRepository;
use App\Infrastructure\Persistance\Repository\Eloquent\EloquentMovieRentRepository;
use App\Infrastructure\Persistance\Repository\Eloquent\EloquentMovieRepository;
use App\Infrastructure\Persistance\Repository\Eloquent\EloquentPaymentRepository;
use App\Infrastructure\Persistance\Repository\Eloquent\EloquentSubscriptionRepository;
use App\Infrastructure\Persistance\Repository\Eloquent\EloquentTransaction;
use App\Infrastructure\Persistance\Repository\Eloquent\EloquentUserRepository;
use App\Infrastructure\Persistance\Repository\Eloquent\EloquentUserSubscriptionRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(MovieRepository::class, function ($app) {
            $movieEloquent = new Movie();

            return new EloquentMovieRepository($movieEloquent);
        });

        $this->app->bind(SubscriptionRepository::class, function ($app) {
            $subscriptionEloquent = new Subscription();

            return new EloquentSubscriptionRepository($subscriptionEloquent);
        });

        $this->app->bind(UserSubscriptionRepository::class, function ($app) {
            $userSubscriptionEloquent = new UserSubscription();

            return new EloquentUserSubscriptionRepository($userSubscriptionEloquent);
        });

        $this->app->bind(EloquentFavoriteRepository::class, function ($app) {
            $favoriteEloquent = new FavoriteMovie();

            return new EloquentFavoriteRepository($favoriteEloquent);
        });

        $this->app->bind(PaymentRepository::class, function ($app) {
            $paymentEloquent = new Payment();

            return new EloquentPaymentRepository($paymentEloquent);
        });

        $this->app->bind(UserRepository::class, function ($app) {
            $userEloquent = new User();

            return new EloquentUserRepository($userEloquent);
        });

        $this->app->bind(MovieRentRepository::class, function ($app) {
            $movieRentEloquent = new MovieRent();

            return new EloquentMovieRentRepository($movieRentEloquent);
        });

        $this->app->bind(GenreRepository::class, function ($app) {
            $genreEloquent = new Genre();

            return new EloquentGenreRepository($genreEloquent);
        });

        $this->app->bind(MovieGenreRepository::class, function ($app) {
            $movieGenreEloquent = new MovieGenre();

            return new EloquentMovieGenreRepository($movieGenreEloquent);
        });

        $this->app->bind(Transaction::class, EloquentTransaction::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
