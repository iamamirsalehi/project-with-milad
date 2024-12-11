<?php

namespace App\Domain\Repository;

use App\Domain\Model\Movie\MovieID;
use App\Domain\Model\Movie\MovieRent;
use App\Domain\Model\Movie\MovieRentID;
use App\Domain\Model\User\UserID;

interface MovieRentRepository
{
    public function findByID(MovieRentID $id): ?MovieRent;

    public function findLatestByUserIDAndMovieID(UserID $userID, MovieID $movieID): ?MovieRent;

    public function save(MovieRent $movieRent): void;
}
