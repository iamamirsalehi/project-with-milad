<?php

namespace App\Src\Instrastructure\Persistance\Repository\Eloquent;

use App\Src\Domain\Model\Movie\MovieID;
use App\Src\Domain\Model\Movie\MovieRent;
use App\Src\Domain\Model\Movie\MovieRentID;
use App\Src\Domain\Model\User\UserID;
use App\Src\Domain\Repository\IMovieRentRepository;

class MovieRentRepository extends EloquentBaseRepository implements IMovieRentRepository
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
