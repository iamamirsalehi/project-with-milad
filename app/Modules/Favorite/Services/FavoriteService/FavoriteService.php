<?php

namespace App\Modules\Favorite\Services\FavoriteService;

use App\Contracts\MessageBus\IMessageBus;
use App\Contracts\Repositories\IFavoriteRepository;
use App\Contracts\Repositories\IMovieRepository;
use App\Modules\Favorite\Models\FavoriteMovie;
use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Movie\Models\IMDBID;
use App\Modules\User\Models\UserID;
use Illuminate\Database\Eloquent\Collection;

readonly class FavoriteService
{
    public function __construct(
        private IMovieRepository    $movieRepository,
        private IFavoriteRepository $favoriteRepository,
        private IMessageBus         $messageBus,
    )
    {
    }

    /**
     * @throws MovieApplicationException
     */
    public function add(IMDBID $IMDBID, UserID $userID): void
    {
        $movie = $this->movieRepository->findByIMDBID($IMDBID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        if (false === $movie->isAvailable()) {
            throw MovieApplicationException::movieIsNotAvailable();
        }

        $favorite = $this->favoriteRepository->findByUserIDAndMovieID($userID, $movie->id);
        if (false === is_null($favorite)) {
            throw MovieApplicationException::movieIsAlreadyAddedToFavoritesList();
        }

        $favorite = FavoriteMovie::new($movie->id, $userID);

        $this->favoriteRepository->save($favorite);

        $this->messageBus->addedFavoriteMovie($favorite);
    }

    /**
     * @throws MovieApplicationException
     */
    public function userMovies(UserID $userID): Collection
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
    public function remove(IMDBID $IMDBID, UserID $userID): void
    {
        $movie = $this->movieRepository->findByIMDBID($IMDBID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        $favorite = $this->favoriteRepository->findByUserIDAndMovieID($userID, $movie->id);
        if (is_null($favorite)) {
            throw MovieApplicationException::movieIsNotInFavoritesList();
        }

        $this->favoriteRepository->remove($favorite);
    }
}
