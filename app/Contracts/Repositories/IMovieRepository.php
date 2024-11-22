<?php

namespace App\Contracts\Repositories;

use App\Modules\Movie\Enums\MovieStatus;
use App\Modules\Movie\Models\Genre;
use App\Modules\Movie\Models\IMDBID;
use App\Modules\Movie\Models\Movie;
use App\Modules\Movie\Models\MovieID;
use Illuminate\Support\Collection;

interface IMovieRepository
{
    public function findByID(MovieID $id): ?Movie;

    public function all(MovieStatus $status = null, Genre $genre = null): Collection;

    public function save(Movie $movie): void;

    public function exists(IMDBID $imdbID): bool;

    public function findByIMDBID(IMDBID $imdbID): ?Movie;
}
