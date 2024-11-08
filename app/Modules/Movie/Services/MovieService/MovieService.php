<?php

namespace App\Modules\Movie\Services\MovieService;

use App\Contracts\Repositories\IMovieRepository;
use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Movie\Models\IMDBID;
use App\Modules\Movie\Models\Movie;
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
    public function add(IMDBID $imdbID): void
    {
        if ($this->movieRepository->exists($imdbID->get())) {
            throw MovieApplicationException::movieAlreadyExists();
        }

        $searchedMovie = $this->movieSearchService->searchByIMDBID($imdbID);

        $movie = Movie::new(
            $searchedMovie->getTitle(),
            $searchedMovie->getLanguage(),
            $searchedMovie->getCountry(),
            $searchedMovie->getPoster(),
            $searchedMovie->getIMDBID(),
            $searchedMovie->getImdbRating(),
            $searchedMovie->getImdbVotes(),
        );

        $this->movieRepository->save($movie);
    }

    /**
     * @throws MovieApplicationException
     */
    public function get(IMDBID $imdbID): Movie
    {
        $movie = $this->movieRepository->findByIMDBID($imdbID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        return $movie;
    }

    /**
     * @throws MovieApplicationException
     */
    public function getIfAvailable(IMDBID $imdbID): Movie
    {
        $movie = $this->get($imdbID);
        if (!$movie->isAvailable()) {
            throw MovieApplicationException::movieIsNotAvailable();
        }

        return $movie;
    }

    /**
     * @throws MovieApplicationException
     */
    public function publish(IMDBID $imdbID): void
    {
        $movie = $this->movieRepository->findByIMDBID($imdbID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        $movie->publish();

        $this->movieRepository->save($movie);
    }

    /**
     * @throws MovieApplicationException
     */
    public function draft(IMDBID $imdbID): void
    {
        $movie = $this->movieRepository->findByIMDBID($imdbID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        $movie->draft();

        $this->movieRepository->save($movie);
    }
}
