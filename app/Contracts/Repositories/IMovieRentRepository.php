<?php

namespace App\Contracts\Repositories;

use App\Modules\Movie\Models\MovieRent;

interface IMovieRentRepository
{
    public function findLatestByUserIDAndMovieID($userID, $movieID): ?MovieRent;

    public function save(MovieRent $movieRent): void;
}
