<?php

namespace App\Domain\Repository;

use App\Domain\Model\Favorite\FavoriteMovie;
use App\Domain\Model\Movie\MovieID;
use App\Domain\Model\User\UserID;
use Illuminate\Database\Eloquent\Collection;

interface FavoriteRepository
{
    public function findByUserIDAndMovieID(UserID $userID, MovieID $movieID): ?FavoriteMovie;

    public function exists(MovieID $movieID, UserID $userID): bool;

    public function save(FavoriteMovie $favoriteMovie): void;

    public function getAllByUserID(UserID $userID): Collection;

    public function remove(FavoriteMovie $favoriteMovie): void;
}
