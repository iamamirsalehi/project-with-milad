<?php

namespace App\Src\Application\CommandHandler\Movie;

use App\Src\Application\Command\Movie\DraftMovieCommand;
use App\Src\Domain\Exceptions\MovieApplicationException;
use App\Src\Domain\Repository\IMovieRepository;

final readonly class DraftMovieCommandHandler
{
    public function __construct(
        private IMovieRepository $movieRepository
    )
    {
    }

    /**
     * @throws MovieApplicationException
     */
    public function __invoke(DraftMovieCommand $draftMovieCommand): void
    {
        $movie = $this->movieRepository->findByIMDBID($draftMovieCommand->iMDBID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        $movie->draft();

        $this->movieRepository->save($movie);
    }
}
