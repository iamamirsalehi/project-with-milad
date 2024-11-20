<?php

namespace App\Modules\Movie\Services\MovieService;

use App\Contracts\Repositories\IGenreRepository;
use App\Contracts\Repositories\IMovieRentRepository;
use App\Contracts\Repositories\IMovieRepository;
use App\Contracts\Repositories\IUserSubscriptionRepository;
use App\Modules\Movie\Enums\MovieStatus;
use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Movie\Models\IMDBID;
use App\Modules\Movie\Models\Movie;
use App\Modules\Movie\Services\MovieGenreService\MovieGenreService;
use App\Modules\Movie\Services\MovieSearchService\IMovieSearchService;
use App\Modules\User\Models\UserID;
use Illuminate\Support\Collection;

readonly class MovieService
{
    public function __construct(
        private IMovieSearchService         $movieSearchService,
        private IMovieRepository            $movieRepository,
        private MovieGenreService           $movieGenreService,
        private IUserSubscriptionRepository $userSubscriptionRepository,
        private IMovieRentRepository        $movieRentRepository,
        private IGenreRepository            $genreRepository,
    )
    {
    }

    /**
     * @throws MovieApplicationException
     */
    public function all(AllMovieFilter $filter): Collection
    {
        if (false === is_null($filter->getGenreName())) {
            $genre = $this->genreRepository->findByName($filter->getGenreName());
            if (is_null($genre)) {
                throw MovieApplicationException::invalidMovieGenreName();
            }

            return $this->movieRepository->all(MovieStatus::Published, $genre);
        }
        return $this->movieRepository->all(MovieStatus::Published);
    }

    /**
     * @throws MovieApplicationException
     */
    public function add(IMDBID $imdbID): void
    {
        if ($this->movieRepository->exists($imdbID)) {
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

        $this->movieGenreService->addMany($imdbID, $searchedMovie->getGenres());
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

    /**
     * @throws MovieApplicationException
     */
    public function watch(IMDBID $imdbID, UserID $userID): void
    {
        $movie = $this->movieRepository->findByIMDBID($imdbID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        $userSubscription = $this->userSubscriptionRepository->findLatestByUserID($userID);
        $movieRent = $this->movieRentRepository->findLatestByUserIDAndMovieID($userID, $movie->id);

        if (is_null($movieRent) && is_null($userSubscription)) {
            throw MovieApplicationException::movieIsNotAccessible();
        }

        if (false === is_null($userSubscription) && false === $userSubscription->isActive()) {
            throw MovieApplicationException::movieIsNotAccessible();
        }

        if (false === is_null($movieRent) && true === $movieRent->isExpired()) {
            throw MovieApplicationException::movieIsNotAccessible();
        }

        if (false === is_null($movieRent) && false === $movieRent->isExpired()) {
            if (false === $movieRent->isWatchingStarted()) {
                $movieRent->startWatching();

                $this->movieRentRepository->save($movieRent);
            }
        }
    }
}
