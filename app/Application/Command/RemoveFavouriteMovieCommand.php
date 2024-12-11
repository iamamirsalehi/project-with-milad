<?php

namespace App\Application\Command;

use App\Domain\Model\Movie\IMDBID;
use App\Domain\Model\User\UserID;

final readonly class RemoveFavouriteMovieCommand
{
    public function __construct(
        public IMDBID $IMDBID,
        public UserID $userID
    )
    {
    }
}
