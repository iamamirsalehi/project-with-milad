<?php

namespace App\Src\Application\CommandHandler\FavouriteMovie;

use App\Src\Application\Command\FavouriteMovie\AddFavouriteMovieCommand;
use App\Src\Domain\Exceptions\MovieApplicationException;
use App\Src\Domain\Model\Favorite\FavoriteMovie;
use App\Src\Domain\Repository\IFavoriteRepository;
use App\Src\Domain\Repository\IMovieRepository;
use App\Src\Instrastructure\MessageBus\IMessageBus;

final readonly class AddFavouriteMovieCommandHandler
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

        //TODO: Change message bus method by dispatch method
        $this->messageBus->addedFavoriteMovie($favorite);
    }
}
