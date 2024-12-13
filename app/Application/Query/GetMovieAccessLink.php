<?php

namespace App\Application\Query;

use App\Domain\Model\Movie\IMDBID;
use App\Domain\Model\User\UserID;

final readonly class GetMovieAccessLink
{
    public function __construct(
        public UserID $userID,
        public IMDBID $imdbID,
    )
    {
    }
}
