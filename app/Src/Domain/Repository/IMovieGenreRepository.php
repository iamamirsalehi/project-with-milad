<?php

namespace App\Src\Domain\Repository;

use App\Src\Domain\Model\Movie\MovieGenre;
use App\Src\Domain\Model\Movie\MovieID;

interface IMovieGenreRepository
{
    public function removeByMovieID(MovieID $movieID): void;

    public function save(MovieGenre $movieGenre): void;
}
