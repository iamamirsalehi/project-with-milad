<?php

namespace App\Src\Application\CommandHandler\Movie;

use App\Src\Application\Command\Movie\GetMovieIfAvailableCommand;
use App\Src\Domain\Exceptions\MovieApplicationException;
use App\Src\Domain\Model\Movie\Movie;
use App\Src\Domain\Repository\IMovieRepository;

class GetMovieIfAvailableCommandHandler
{
    public function __construct(
        private IMovieRepository $movieRepository
    )
    {
    }

    /**
     * @throws MovieApplicationException
     */
    public function __invoke(GetMovieIfAvailableCommand $getMovieIfAvailableCommand): Movie
    {
        $movie = $this->movieRepository->findByIMDBID($getMovieIfAvailableCommand->imdbID);
        if (!$movie->isAvailable()) {
            throw MovieApplicationException::movieIsNotAvailable();
        }

        return $movie;
    }
}
