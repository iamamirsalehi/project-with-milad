<?php

namespace App\Application\Service\MovieSearchService;

use App\Domain\Exceptions\MovieApplicationException;
use App\Domain\Model\Movie\IMDBID;

interface IMovieSearchService
{
    /**
     * @throws MovieApplicationException
     */
    public function searchByIMDBID(IMDBID $imdbID): MovieInfo;
}
