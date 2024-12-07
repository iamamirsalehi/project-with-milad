<?php

namespace App\Src\Instrastructure\MessageBus;

use App\Src\Domain\Model\Favorite\FavoriteMovie;

interface IMessageBus
{
    public function addedFavoriteMovie(FavoriteMovie $favoriteMovie): void;
}
