<?php

namespace App\Providers;

use App\Contracts\Repositories\Eloquent\FavoriteRepository;
use App\Contracts\Repositories\Eloquent\GenreRepository;
use App\Contracts\Repositories\Eloquent\MovieRentRepository;
use App\Contracts\Repositories\Eloquent\MovieRepository;
use App\Contracts\Repositories\Eloquent\PaymentRepository;
use App\Contracts\Repositories\Eloquent\SubscriptionRepository;
use App\Contracts\Repositories\Eloquent\Transaction;
use App\Contracts\Repositories\Eloquent\UserRepository;
use App\Contracts\Repositories\Eloquent\UserSubscriptionRepository;
use App\Contracts\Repositories\IFavoriteRepository;
use App\Contracts\Repositories\IGenreRepository;
use App\Contracts\Repositories\IMovieRentRepository;
use App\Contracts\Repositories\IMovieRepository;
use App\Contracts\Repositories\IPaymentRepository;
use App\Contracts\Repositories\ISubscriptionRepository;
use App\Contracts\Repositories\ITransaction;
use App\Contracts\Repositories\IUserRepository;
use App\Contracts\Repositories\IUserSubscriptionRepository;
use App\Modules\Favorite\Models\FavoriteMovie;
use App\Modules\Movie\Models\Genre;
use App\Modules\Movie\Models\Movie;
use App\Modules\Movie\Models\MovieRent;
use App\Modules\Payment\Models\Payment;
use App\Modules\Subscription\Models\Subscription;
use App\Modules\Subscription\Models\UserSubscription;
use App\Modules\User\Models\User;
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

        $this->app->bind(IMovieRentRepository::class, function ($app){
            $movieRentEloquent = new MovieRent();

            return new MovieRentRepository($movieRentEloquent);
        });

        $this->app->bind(IGenreRepository::class, function ($app){
            $genreEloquent = new Genre();

            return new GenreRepository($genreEloquent);
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
