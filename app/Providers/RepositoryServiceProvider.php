<?php

namespace App\Providers;

use App\Contracts\Repositories\Eloquent\FavoriteRepository;
use App\Contracts\Repositories\Eloquent\MovieRepository;
use App\Contracts\Repositories\Eloquent\SubscriptionRepository;
use App\Contracts\Repositories\Eloquent\UserSubscriptionRepository;
use App\Contracts\Repositories\IFavoriteRepository;
use App\Contracts\Repositories\IMovieRepository;
use App\Contracts\Repositories\ISubscriptionRepository;
use App\Contracts\Repositories\IUserSubscriptionRepository;
use App\Modules\Favorite\Models\FavoriteMovie;
use App\Modules\Movie\Models\Movie;
use App\Modules\Subscription\Models\Subscription;
use App\Modules\Subscription\Models\UserSubscription;
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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
