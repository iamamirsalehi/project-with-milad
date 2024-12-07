<?php

namespace App\Src\Application\Service\MovieSearchService;

use App\Src\Domain\Exceptions\MovieApplicationException;
use App\Src\Domain\Model\Movie\IMDBID;

interface IMovieSearchService
{
    /**
     * @throws MovieApplicationException
     */
    public function searchByIMDBID(IMDBID $imdbID): MovieInfo;
}
