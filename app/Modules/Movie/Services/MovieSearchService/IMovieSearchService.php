<?php

namespace App\Modules\Movie\Services\MovieSearchService;

use App\Modules\Movie\Exceptions\MovieApplicationException;

interface IMovieSearchService
{
    /**
     * @throws MovieApplicationException
     */
    public function searchByIMDBID(string $imdbID): MovieInfo;
}
