<?php

namespace App\Src\Application\Command\Movie;

use App\Src\Domain\Model\Movie\IMDBID;

final readonly class PublishMovieCommand
{
    public function __construct(public IMDBID $iMDBID)
    {
    }
}
