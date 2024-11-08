<?php

namespace App\Contracts\Repositories\Eloquent;

use App\Contracts\Repositories\IMovieRentRepository;
use App\Modules\Movie\Models\MovieRent;

class MovieRentRepository extends EloquentBaseRepository implements IMovieRentRepository
{
    public function findLatestByUserIDAndMovieID($userID, $movieID): ?MovieRent
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
}
