<?php

namespace App\Src\Application\CommandHandler\Movie;

use App\Src\Application\Command\Movie\WatchMovieCommand;
use App\Src\Domain\Exceptions\MovieApplicationException;
use App\Src\Domain\Repository\IMovieRentRepository;
use App\Src\Domain\Repository\IMovieRepository;
use App\Src\Domain\Repository\IUserSubscriptionRepository;

final readonly class WatchMovieCommandHandler
{
    public function __construct(
        private IMovieRepository            $movieRepository,
        private IMovieRentRepository        $movieRentRepository,
        private IUserSubscriptionRepository $userSubscriptionRepository,
    )
    {
    }

    /**
     * @throws MovieApplicationException
     */
    public function __invoke(WatchMovieCommand $watchMovieCommand): void
    {
        $movie = $this->movieRepository->findByIMDBID($watchMovieCommand->imdbID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        $userSubscription = $this->userSubscriptionRepository->findLatestByUserID($watchMovieCommand->userID);

        $movieRent = $this->movieRentRepository->findLatestByUserIDAndMovieID($watchMovieCommand->userID, $movie->id);

        if (!is_null($userSubscription)) {
            $userSubscription->watch();
            return;
        }

        if (!is_null($movieRent)) {
            $movieRent->watch();

            $this->movieRentRepository->save($movieRent);
            return;
        }

        throw MovieApplicationException::movieIsNotAccessible();
    }
}
