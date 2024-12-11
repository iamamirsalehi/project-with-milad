<?php

namespace App\Application\CommandHandler;

use App\Application\Command\ActivateMovieRentCommand;
use App\Domain\Exceptions\MovieApplicationException;
use App\Domain\Repository\MovieRentRepository;

final readonly class ActivateMovieRentCommandHandler
{
    public function __construct(
        private MovieRentRepository $movieRentRepository
    )
    {
    }

    /**
     * @throws MovieApplicationException
     */
    public function __invoke(ActivateMovieRentCommand $activateMovieRentCommand): void
    {
        $movieRent = $this->movieRentRepository->findLatestByUserIDAndMovieID(
            $activateMovieRentCommand->userID,
            $activateMovieRentCommand->movieID
        );

        if (is_null($movieRent)) {
            throw MovieApplicationException::movieRentDoesNotExist();
        }

        $movieRent->activate();

        $this->movieRentRepository->save($movieRent);
    }
}
