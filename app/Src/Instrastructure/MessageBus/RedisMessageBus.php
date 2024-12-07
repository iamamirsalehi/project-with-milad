<?php

namespace App\Src\Instrastructure\MessageBus;

use App\Src\Domain\Model\Favorite\FavoriteMovie;
use Illuminate\Support\Facades\Redis;

class RedisMessageBus implements IMessageBus
{
    private const FAVORITE_MOVIE_CHANNEL = 'favorite-movie-channel';

    public function addedFavoriteMovie(FavoriteMovie $favoriteMovie): void
    {
        Redis::publish(self::FAVORITE_MOVIE_CHANNEL, serialize($favoriteMovie));
    }
}
