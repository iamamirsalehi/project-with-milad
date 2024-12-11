<?php

namespace App\Application\CommandHandler;

use App\Application\Command\WatchMovieCommand;
use App\Domain\Exceptions\MovieApplicationException;
use App\Domain\Repository\MovieRentRepository;
use App\Domain\Repository\MovieRepository;
use App\Domain\Repository\UserSubscriptionRepository;

final readonly class WatchMovieCommandHandler
{
    public function __construct(
        private MovieRepository            $movieRepository,
        private MovieRentRepository        $movieRentRepository,
        private UserSubscriptionRepository $userSubscriptionRepository,
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
