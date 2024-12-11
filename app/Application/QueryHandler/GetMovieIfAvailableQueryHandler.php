<?php

namespace App\Application\QueryHandler;

use App\Application\Query\GetMovieIfAvailableQuery;
use App\Domain\Exceptions\MovieApplicationException;
use App\Domain\Model\Movie\Movie;
use App\Domain\Repository\MovieRepository;

class GetMovieIfAvailableQueryHandler
{
    public function __construct(
        private MovieRepository $movieRepository
    )
    {
    }

    /**
     * @throws MovieApplicationException
     */
    public function __invoke(GetMovieIfAvailableQuery $getMovieIfAvailableCommand): Movie
    {
        $movie = $this->movieRepository->findByIMDBID($getMovieIfAvailableCommand->imdbID);
        if (!$movie->isAvailable()) {
            throw MovieApplicationException::movieIsNotAvailable();
        }

        return $movie;
    }
}
