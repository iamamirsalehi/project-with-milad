<?php

namespace App\Src\Domain\Repository;

use App\Src\Domain\Model\Movie\MovieID;
use App\Src\Domain\Model\Movie\MovieRent;
use App\Src\Domain\Model\Movie\MovieRentID;
use App\Src\Domain\Model\User\UserID;

interface IMovieRentRepository
{
    public function findByID(MovieRentID $id): ?MovieRent;

    public function findLatestByUserIDAndMovieID(UserID $userID, MovieID $movieID): ?MovieRent;

    public function save(MovieRent $movieRent): void;
}
