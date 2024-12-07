<?php

namespace App\Src\Application\CommandHandler\FavouriteMovie;

use App\Src\Application\Command\FavouriteMovie\RemoveFavouriteMovieCommand;
use App\Src\Domain\Exceptions\MovieApplicationException;
use App\Src\Domain\Repository\IFavoriteRepository;
use App\Src\Domain\Repository\IMovieRepository;

final readonly class RemoveFavouriteMovieCommandHandler
{
    public function __construct(
        private IMovieRepository $movieRepository,
        private IFavoriteRepository $favoriteRepository,
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
