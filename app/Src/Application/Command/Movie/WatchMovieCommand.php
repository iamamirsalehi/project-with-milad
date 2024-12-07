<?php

namespace App\Src\Application\Command\Movie;

use App\Src\Domain\Model\Movie\IMDBID;
use App\Src\Domain\Model\User\UserID;

final readonly class WatchMovieCommand
{
    public function __construct(
        public UserID $userID,
        public IMDBID $imdbID,
    )
    {
    }
}
