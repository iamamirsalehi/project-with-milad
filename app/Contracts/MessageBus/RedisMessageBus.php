<?php

namespace App\Contracts\MessageBus;

use App\Modules\Favorite\Models\FavoriteMovie;
use Illuminate\Support\Facades\Redis;

class RedisMessageBus implements IMessageBus
{
    private const FAVORITE_MOVIE_CHANNEL = 'favorite-movie-channel';

    public function addedFavoriteMovie(FavoriteMovie $favoriteMovie): void
    {
        Redis::publish(self::FAVORITE_MOVIE_CHANNEL, serialize($favoriteMovie));
    }
}
