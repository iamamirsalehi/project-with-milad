<?php

namespace App\Contracts\Repositories;

use App\Contracts\Repositories\Dto\BaseResult;
use App\Models\Movie;

interface IMovieRepository extends IRepository
{
    public function exists(string $imdbID): bool;

    public function findByIMDBID(string $imdbID): ?BaseResult;
}
