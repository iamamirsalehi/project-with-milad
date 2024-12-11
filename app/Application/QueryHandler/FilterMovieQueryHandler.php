<?php

namespace App\Application\QueryHandler;

use App\Application\Query\FilterMovieQuery;
use App\Domain\Enums\MovieStatus;
use App\Domain\Exceptions\MovieApplicationException;
use App\Domain\Repository\GenreRepository;
use App\Domain\Repository\MovieRepository;
use Illuminate\Support\Collection;

final readonly class FilterMovieQueryHandler
{
    public function __construct(
        private GenreRepository $genreRepository,
        private MovieRepository $movieRepository,
    )
    {

    }

    /**
     * @throws MovieApplicationException
     */
    public function __invoke(FilterMovieQuery $allMovieCommand): Collection
    {
        if (false === is_null($allMovieCommand->getGenreName())) {
            $genre = $this->genreRepository->findByName($allMovieCommand->getGenreName());
            if (is_null($genre)) {
                throw MovieApplicationException::invalidMovieGenreName();
            }

            return $this->movieRepository->filter(MovieStatus::Published, $genre);
        }

        return $this->movieRepository->filter(MovieStatus::Published);
    }
}
