<?php

namespace App\Domain\Repository;

use App\Domain\Model\Movie\MovieGenre;
use App\Domain\Model\Movie\MovieID;

interface MovieGenreRepository
{
    public function removeByMovieID(MovieID $movieID): void;

    public function save(MovieGenre $movieGenre): void;
}
