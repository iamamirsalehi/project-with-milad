<?php

namespace App\Modules\Movie\Services\MovieSearchService;

use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Movie\Models\IMDBID;

interface IMovieSearchService
{
    /**
     * @throws MovieApplicationException
     */
    public function searchByIMDBID(IMDBID $imdbID): MovieInfo;
}
