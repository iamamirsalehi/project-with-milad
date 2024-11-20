<?php

namespace App\Contracts\Repositories;

use App\Modules\Movie\Models\MovieID;
use App\Modules\Movie\Models\MovieRent;
use App\Modules\Movie\Models\MovieRentID;
use App\Modules\User\Models\UserID;

interface IMovieRentRepository
{
    public function findByID(MovieRentID $id): ?MovieRent;

    public function findLatestByUserIDAndMovieID(UserID $userID, MovieID $movieID): ?MovieRent;

    public function save(MovieRent $movieRent): void;
}
