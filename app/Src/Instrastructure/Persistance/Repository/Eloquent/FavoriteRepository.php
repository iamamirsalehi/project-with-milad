<?php

namespace App\Src\Instrastructure\Persistance\Repository\Eloquent;

use App\Src\Domain\Model\Favorite\FavoriteMovie;
use App\Src\Domain\Model\Movie\MovieID;
use App\Src\Domain\Model\User\UserID;
use App\Src\Domain\Repository\IFavoriteRepository;
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
