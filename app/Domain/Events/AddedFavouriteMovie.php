<?php

namespace App\Domain\Events;

use App\Domain\Model\Favorite\FavoriteMovie;
use App\Infrastructure\MessageBus\EventMessageBus;

final readonly class AddedFavouriteMovie implements EventMessageBus
{
    public function __construct(public FavoriteMovie $favoriteMovie)
    {
    }

    public function getChannelName(): string
    {
        return 'favourite-movies';
    }
}
