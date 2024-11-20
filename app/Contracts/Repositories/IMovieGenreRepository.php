<?php

namespace App\Contracts\Repositories;

use App\Modules\Movie\Models\MovieGenre;
use App\Modules\Movie\Models\MovieID;

interface IMovieGenreRepository
{
    public function removeByMovieID(MovieID $movieID): void;

    public function save(MovieGenre $movieGenre): void;
}
