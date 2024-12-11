<?php

namespace App\Application\CommandHandler;

use App\Application\Command\RemoveFavouriteMovieCommand;
use App\Domain\Exceptions\MovieApplicationException;
use App\Domain\Repository\FavoriteRepository;
use App\Domain\Repository\MovieRepository;

final readonly class RemoveFavouriteMovieCommandHandler
{
    public function __construct(
        private MovieRepository    $movieRepository,
        private FavoriteRepository $favoriteRepository,
    )
    {
    }

    /**
     * @throws MovieApplicationException
     */
    public function __invoke(RemoveFavouriteMovieCommand $removeFavouriteMovieCommand): void
    {
        $movie = $this->movieRepository->findByIMDBID($removeFavouriteMovieCommand->IMDBID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        $favorite = $this->favoriteRepository->findByUserIDAndMovieID($removeFavouriteMovieCommand->userID, $movie->id);
        if (is_null($favorite)) {
            throw MovieApplicationException::movieIsNotInFavoritesList();
        }

        $this->favoriteRepository->remove($favorite);
    }
}
