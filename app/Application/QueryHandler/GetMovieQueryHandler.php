<?php

namespace App\Application\QueryHandler;

use App\Application\Query\GetMovieQuery;
use App\Domain\Exceptions\MovieApplicationException;
use App\Domain\Model\Movie\Movie;
use App\Domain\Repository\MovieRepository;

final readonly class GetMovieQueryHandler
{
    public function __construct(
        private MovieRepository $movieRepository,
    )
    {

    }

    /**
     * @throws MovieApplicationException
     */
    public function __invoke(GetMovieQuery $adminGetMovieCommand): Movie
    {
        $movie = $this->movieRepository->findByIMDBID($adminGetMovieCommand->iMDBID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        return $movie;
    }
}
