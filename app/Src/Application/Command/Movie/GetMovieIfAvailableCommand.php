<?php

namespace App\Src\Application\Command\Movie;

use App\Src\Domain\Model\Movie\IMDBID;

final readonly class GetMovieIfAvailableCommand
{
    public function __construct(
        public IMDBID $imdbID
    )
    {

    }
}
