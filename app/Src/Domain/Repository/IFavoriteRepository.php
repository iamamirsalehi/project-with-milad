<?php

namespace App\Src\Domain\Repository;

use App\Src\Domain\Model\Favorite\FavoriteMovie;
use App\Src\Domain\Model\Movie\MovieID;
use App\Src\Domain\Model\User\UserID;
use Illuminate\Database\Eloquent\Collection;

interface IFavoriteRepository
{
    public function findByUserIDAndMovieID(UserID $userID, MovieID $movieID): ?FavoriteMovie;

    public function exists(MovieID $movieID, UserID $userID): bool;

    public function save(FavoriteMovie $favoriteMovie): void;

    public function getAllByUserID(UserID $userID): Collection;

    public function remove(FavoriteMovie $favoriteMovie): void;
}
