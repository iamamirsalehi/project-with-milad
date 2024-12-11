<?php

namespace App\Application\Command;

use App\Domain\Model\Movie\IMDBID;
use App\Domain\Model\User\UserID;

final readonly class AddFavouriteMovieCommand
{
    public function __construct(
        public IMDBID $imdbID,
        public UserID $userID,
    )
    {
    }
}
