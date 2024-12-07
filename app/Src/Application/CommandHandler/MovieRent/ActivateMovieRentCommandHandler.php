<?php

namespace App\Src\Application\CommandHandler\MovieRent;

use App\Src\Application\Command\MovieRent\ActivateMovieRentCommand;
use App\Src\Domain\Exceptions\MovieApplicationException;
use App\Src\Domain\Repository\IMovieRentRepository;

final readonly class ActivateMovieRentCommandHandler
{
    public function __construct(
        private IMovieRentRepository $movieRentRepository
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
