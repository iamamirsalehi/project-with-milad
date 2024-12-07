<?php

namespace App\Src\Application\Command\Movie;

use App\Src\Domain\Model\Movie\IMDBID;

final readonly class DraftMovieCommand
{
    public function __construct(public IMDBID $iMDBID)
    {

    }
}
