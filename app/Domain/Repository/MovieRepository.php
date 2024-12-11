<?php

namespace App\Domain\Repository;

use App\Domain\Enums\MovieStatus;
use App\Domain\Model\Movie\Genre;
use App\Domain\Model\Movie\IMDBID;
use App\Domain\Model\Movie\Movie;
use App\Domain\Model\Movie\MovieID;
use Illuminate\Support\Collection;

interface MovieRepository
{
    public function findByID(MovieID $id): ?Movie;

    //TODO: Change it
    public function filter(MovieStatus $status = null, Genre $genre = null): Collection;

    public function save(Movie $movie): void;

    public function exists(IMDBID $imdbID): bool;

    public function findByIMDBID(IMDBID $imdbID): ?Movie;
}
