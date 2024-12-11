<?php

namespace App\Application\Query;

use App\Domain\Model\Movie\IMDBID;

final readonly class GetMovieQuery
{
    public function __construct(public IMDBID $iMDBID)
    {
    }
}
