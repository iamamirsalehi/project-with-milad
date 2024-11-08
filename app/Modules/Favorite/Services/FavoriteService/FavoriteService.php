<?php

namespace App\Modules\Favorite\Services\FavoriteService;

use App\Contracts\Redis\IRedis;
use App\Contracts\Repositories\IFavoriteRepository;
use App\Contracts\Repositories\IMovieRepository;
use App\Modules\Favorite\Models\FavoriteMovie;
use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Movie\Models\IMDBID;
use Illuminate\Database\Eloquent\Collection;

readonly class FavoriteService
{
    public function __construct(
        private IMovieRepository    $movieRepository,
        private IFavoriteRepository $favoriteRepository,
        private IRedis              $redis,
    )
    {
    }

    /**
     * @throws MovieApplicationException
     */
    public function add(IMDBID $IMDBID, int $userID): void
    {
        $movie = $this->movieRepository->findByIMDBID($IMDBID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        if (!$movie->isAvailable()) {
            throw MovieApplicationException::movieIsNotAvailable();
        }

        $favorite = $this->favoriteRepository->findByUserIDAndMovieID($movie->id, $userID);
        if (false === is_null($favorite) && false === $favorite->isRemoved()) {
            throw MovieApplicationException::movieIsAlreadyAddedToFavoritesList();
        }

        $favorite = FavoriteMovie::new($movie->id, $userID);

        $this->favoriteRepository->save($favorite);

        $this->redis->publish('favorite-movies', serialize($favorite));
    }

    /**
     * @throws MovieApplicationException
     */
    public function userMovies(int $userID): Collection
    {
        $userFavoriteList = $this->favoriteRepository->getAllByUserID($userID);
        if (empty($userFavoriteList->isEmpty())) {
            throw MovieApplicationException::userDoesNotHaveAnyFavoritesMovie();
        }

        return $userFavoriteList;
    }

    /**
     * @throws MovieApplicationException
     */
    public function remove(IMDBID $IMDBID, int $userID): void
    {
        $movie = $this->movieRepository->findByIMDBID($IMDBID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        $favorite = $this->favoriteRepository->findByUserIDAndMovieID($movie->id, $userID);
        if (is_null($favorite)) {
            throw MovieApplicationException::movieIsNotInFavoritesList();
        }

        if ($favorite->isRemoved()) {
            throw MovieApplicationException::favoriteMovieIsAlreadyRemoved();
        }

        $this->favoriteRepository->remove($favorite);
    }
}
