<?php

namespace App\Application\Query;

use App\Domain\Model\Movie\IMDBID;

final readonly class GetMovieIfAvailableQuery
{
    public function __construct(
        public IMDBID $imdbID
    )
    {

    }
}
