<?php

namespace App\Contracts\Repositories;

use App\Modules\Favorite\Models\FavoriteMovie;
use Illuminate\Database\Eloquent\Collection;

interface IFavoriteRepository
{
    public function findByUserIDAndMovieID(int $userID, int $movieID): ?FavoriteMovie;

    public function exists(int $movieID, int $userID): bool;

    public function save(FavoriteMovie $favoriteMovie): void;

    public function getAllByUserID(int $userID): Collection;

    public function remove(FavoriteMovie $favoriteMovie): void;
}
