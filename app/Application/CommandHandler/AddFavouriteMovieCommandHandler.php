<?php

namespace App\Application\CommandHandler;

use App\Application\Command\AddFavouriteMovieCommand;
use App\Domain\Events\AddedFavouriteMovie;
use App\Domain\Exceptions\MovieApplicationException;
use App\Domain\Model\Favorite\FavoriteMovie;
use App\Domain\Repository\FavoriteRepository;
use App\Domain\Repository\MovieRepository;
use App\Infrastructure\MessageBus\MessageBus;

final readonly class AddFavouriteMovieCommandHandler
{
    public function __construct(
        private MovieRepository    $movieRepository,
        private FavoriteRepository $favoriteRepository,
        private MessageBus         $messageBus,
    )
    {

    }

    /**
     * @throws MovieApplicationException
     */
    public function __invoke(AddFavouriteMovieCommand $addFavouriteMovieCommand): void
    {
        $movie = $this->movieRepository->findByIMDBID($addFavouriteMovieCommand->imdbID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        if (false === $movie->isAvailable()) {
            throw MovieApplicationException::movieIsNotAvailable();
        }

        $favorite = $this->favoriteRepository->findByUserIDAndMovieID($addFavouriteMovieCommand->userID, $movie->id);
        if (false === is_null($favorite)) {
            throw MovieApplicationException::movieIsAlreadyAddedToFavoritesList();
        }

        $favorite = FavoriteMovie::new($movie->id, $addFavouriteMovieCommand->userID);

        $this->favoriteRepository->save($favorite);

        $this->messageBus->dispatch(new AddedFavouriteMovie($favorite));
    }
}
