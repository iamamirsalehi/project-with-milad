<?php

namespace App\Contracts\Repositories\Eloquent;

use App\Contracts\Repositories\IFavoriteRepository;
use App\Modules\Favorite\Models\FavoriteMovie;
use Illuminate\Database\Eloquent\Collection;

class FavoriteRepository extends EloquentBaseRepository implements IFavoriteRepository
{
    public function exists(int $movieID, int $userID): bool
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

    public function getAllByUserID(int $userID): Collection
    {
        return $this->model->newQuery()
            ->with(['movie'])
            ->where('user_id', $userID)
            ->get();
    }

    public function findByUserIDAndMovieID(int $userID, int $movieID): ?FavoriteMovie
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
