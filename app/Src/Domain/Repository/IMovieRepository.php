<?php

namespace App\Src\Domain\Repository;

use App\Src\Domain\Enums\MovieStatus;
use App\Src\Domain\Model\Movie\Genre;
use App\Src\Domain\Model\Movie\IMDBID;
use App\Src\Domain\Model\Movie\Movie;
use App\Src\Domain\Model\Movie\MovieID;
use Illuminate\Support\Collection;

interface IMovieRepository
{
    public function findByID(MovieID $id): ?Movie;

    //TODO: Change it
    public function filter(MovieStatus $status = null, Genre $genre = null): Collection;

    public function save(Movie $movie): void;

    public function exists(IMDBID $imdbID): bool;

    public function findByIMDBID(IMDBID $imdbID): ?Movie;
}
