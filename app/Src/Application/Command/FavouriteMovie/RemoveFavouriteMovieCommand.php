<?php

namespace App\Src\Application\Command\FavouriteMovie;

use App\Src\Domain\Model\Movie\IMDBID;
use App\Src\Domain\Model\User\UserID;

final readonly class RemoveFavouriteMovieCommand
{
    public function __construct(
        public IMDBID $IMDBID,
        public UserID $userID
    )
    {
    }
}
