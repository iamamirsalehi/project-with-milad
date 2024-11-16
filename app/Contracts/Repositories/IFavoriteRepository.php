<?php

namespace App\Contracts\Repositories;

use App\Modules\Favorite\Models\FavoriteMovie;
use App\Modules\Movie\Models\MovieID;
use App\Modules\User\Models\UserID;
use Illuminate\Database\Eloquent\Collection;

interface IFavoriteRepository
{
    public function findByUserIDAndMovieID(UserID $userID, MovieID $movieID): ?FavoriteMovie;

    public function exists(MovieID $movieID, UserID $userID): bool;

    public function save(FavoriteMovie $favoriteMovie): void;

    public function getAllByUserID(UserID $userID): Collection;

    public function remove(FavoriteMovie $favoriteMovie): void;
}
