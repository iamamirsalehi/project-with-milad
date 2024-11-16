<?php

namespace App\Contracts\Repositories\Eloquent;

use App\Contracts\Repositories\IFavoriteRepository;
use App\Modules\Favorite\Models\FavoriteMovie;
use App\Modules\Movie\Models\MovieID;
use App\Modules\User\Models\UserID;
use Illuminate\Database\Eloquent\Collection;

class FavoriteRepository extends EloquentBaseRepository implements IFavoriteRepository
{
    public function exists(MovieID $movieID, UserID $userID): bool
    {
        return $this->model->newQuery()
            ->where('user_id', $userID)
            ->where('movie_id', $movieID)
            ->exists();
    }

    public function save(FavoriteMovie $favoriteMovie): void
    {
        $favoriteMovie->save();
    }

    public function getAllByUserID(UserID $userID): Collection
    {
        return $this->model->newQuery()
            ->with(['movie'])
            ->where('user_id', $userID)
            ->get();
    }

    public function findByUserIDAndMovieID(UserID $userID, MovieID $movieID): ?FavoriteMovie
    {
        return $this->model->newQuery()
            ->where('user_id', $userID)
            ->where('movie_id', $movieID)
            ->first();
    }

    public function remove(FavoriteMovie $favoriteMovie): void
    {
        $favoriteMovie->delete();
    }
}
