<?php

namespace App\Contracts\Repositories\Eloquent;

use App\Contracts\Repositories\IMovieRentRepository;
use App\Modules\Movie\Models\MovieID;
use App\Modules\Movie\Models\MovieRent;
use App\Modules\Movie\Models\MovieRentID;
use App\Modules\User\Models\UserID;

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
