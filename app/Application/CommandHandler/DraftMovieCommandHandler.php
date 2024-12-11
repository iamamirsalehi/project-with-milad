<?php

namespace App\Application\CommandHandler;

use App\Application\Command\DraftMovieCommand;
use App\Domain\Exceptions\MovieApplicationException;
use App\Domain\Repository\MovieRepository;

final readonly class DraftMovieCommandHandler
{
    public function __construct(
        private MovieRepository $movieRepository
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
