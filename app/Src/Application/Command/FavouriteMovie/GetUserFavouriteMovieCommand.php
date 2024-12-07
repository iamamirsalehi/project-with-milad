<?php

namespace App\Src\Application\Command\FavouriteMovie;

use App\Src\Domain\Model\User\UserID;

final readonly class GetUserFavouriteMovieCommand
{
    public function __construct(public UserID $userID)
    {
    }
}
