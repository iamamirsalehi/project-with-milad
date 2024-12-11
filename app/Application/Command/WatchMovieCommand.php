<?php

namespace App\Application\Command;

use App\Domain\Model\Movie\IMDBID;
use App\Domain\Model\User\UserID;

final readonly class WatchMovieCommand
{
    public function __construct(
        public UserID $userID,
        public IMDBID $imdbID,
    )
    {
    }
}
