<?php

namespace App\Infrastructure\Persistance\Repository\Eloquent;

use App\Domain\Model\Movie\MovieID;
use App\Domain\Model\Movie\MovieRent;
use App\Domain\Model\Movie\MovieRentID;
use App\Domain\Model\User\UserID;
use App\Domain\Repository\MovieRentRepository;

class EloquentMovieRentRepository extends EloquentBaseRepository implements MovieRentRepository
{
    public function findLatestByUserIDAndMovieID(UserID $userID, MovieID $movieID): ?MovieRent
    {
        return $this->model->newQuery()
            ->where('user_id', $userID)
            ->where('movie_id', $movieID)
            ->orderByDesc('id')
            ->first();
    }

    public function save(MovieRent $movieRent): void
    {
        $movieRent->save();
    }

    public function findByID(MovieRentID $id): ?MovieRent
    {
        return $this->model->newQuery()
            ->where('id', $id)
            ->first();
    }
}
