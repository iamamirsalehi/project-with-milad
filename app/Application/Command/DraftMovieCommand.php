<?php

namespace App\Application\Command;

use App\Domain\Model\Movie\IMDBID;

final readonly class DraftMovieCommand
{
    public function __construct(public IMDBID $iMDBID)
    {

    }
}
