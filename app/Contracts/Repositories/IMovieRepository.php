<?php

namespace App\Contracts\Repositories;

use App\Modules\Movie\Models\IMDBID;
use App\Modules\Movie\Models\Movie;

interface IMovieRepository
{
    public function save(Movie $movie): void;

    public function exists(IMDBID $imdbID): bool;

    public function findByIMDBID(IMDBID $imdbID): ?Movie;
}
