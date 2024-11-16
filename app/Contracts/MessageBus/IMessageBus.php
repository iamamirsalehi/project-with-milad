<?php

namespace App\Contracts\MessageBus;

use App\Modules\Favorite\Models\FavoriteMovie;

interface IMessageBus
{
    public function addedFavoriteMovie(FavoriteMovie $favoriteMovie): void;
}
