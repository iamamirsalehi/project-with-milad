<?php

namespace App\Src\Application\CommandHandler\Movie;

use App\Src\Application\Command\Movie\GetMovieCommand;
use App\Src\Domain\Exceptions\MovieApplicationException;
use App\Src\Domain\Model\Movie\Movie;
use App\Src\Domain\Repository\IMovieRepository;

final readonly class GetMovieCommandHandler
{
    public function __construct(
        private IMovieRepository $movieRepository,
    )
    {

    }

    /**
     * @throws MovieApplicationException
     */
    public function __invoke(GetMovieCommand $adminGetMovieCommand): Movie
    {
        $movie = $this->movieRepository->findByIMDBID($adminGetMovieCommand->iMDBID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        return $movie;
    }
}
