<?php

namespace App\Modules\Movie\Services\MovieService;

use App\Contracts\Repositories\Eloquent\Movie\MovieData;
use App\Contracts\Repositories\Eloquent\Movie\MovieResult;
use App\Contracts\Repositories\IMovieRepository;
use App\Modules\Movie\Enums\MovieStatus;
use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Movie\Services\MovieSearchService\IMovieSearchService;

readonly class MovieService
{
    public function __construct(
        private IMovieSearchService $movieSearchService,
        private IMovieRepository    $movieRepository,
    )
    {
    }

    /**
     * @throws MovieApplicationException
     */
    public function add(string $imdbID): MovieResult
    {
        if ($this->movieRepository->exists($imdbID)) {
            throw MovieApplicationException::movieAlreadyExists();
        }

        $searchedMovie = $this->movieSearchService->searchByIMDBID($imdbID);

        $movieData = new MovieData(
            $searchedMovie->getTitle(),
            $searchedMovie->getLanguage(),
            $searchedMovie->getCountry(),
            $searchedMovie->getPoster(),
            $searchedMovie->getImdbRating(),
            $searchedMovie->getImdbID(),
            $searchedMovie->getImdbVotes()
        );

        return $this->movieRepository->create($movieData);
    }

    /**
     * @throws MovieApplicationException
     */
    public function get(string $imdbID): MovieResult
    {
        /** @var MovieResult $movie */
        $movie = $this->movieRepository->findByIMDBID($imdbID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        return $movie;
    }

    /**
     * @throws MovieApplicationException
     */
    public function getIfAvailable(string $imdbID): MovieResult
    {
        $movie = $this->get($imdbID);
        if (!$this->isMovieAvailable($movie)) {
            throw MovieApplicationException::movieIsNotAvailable();
        }

        return $movie;
    }

    public function exists(string $imdbID): bool
    {
        return $this->movieRepository->exists($imdbID);
    }

    private function isMovieAvailable(MovieResult $movie): bool
    {
        return !is_null($movie->getUrl()) && $movie->getStatus() == MovieStatus::Published;
    }
}
