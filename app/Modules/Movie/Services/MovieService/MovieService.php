<?php

namespace App\Modules\Movie\Services\MovieService;

use App\Contracts\Repositories\IGenreRepository;
use App\Contracts\Repositories\IMovieGenreRepository;
use App\Contracts\Repositories\IMovieRentRepository;
use App\Contracts\Repositories\IMovieRepository;
use App\Contracts\Repositories\ITransaction;
use App\Contracts\Repositories\IUserSubscriptionRepository;
use App\Modules\Movie\Enums\MovieStatus;
use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Movie\Models\GenreName;
use App\Modules\Movie\Models\IMDBID;
use App\Modules\Movie\Models\Movie;
use App\Modules\Movie\Models\MovieGenre;
use App\Modules\Movie\Services\MovieSearchService\IMovieSearchService;
use App\Modules\User\Models\UserID;
use Illuminate\Support\Collection;

final readonly class MovieService
{
    public function __construct(
        private IMovieSearchService         $movieSearchService,
        private IMovieRepository            $movieRepository,
        private IUserSubscriptionRepository $userSubscriptionRepository,
        private IMovieRentRepository        $movieRentRepository,
        private IGenreRepository            $genreRepository,
        private IMovieGenreRepository       $movieGenreRepository,
        private ITransaction                $transaction,
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


        $this->transaction->begin(function () use ($movie, $searchedMovie, $imdbID) {
            $this->movieRepository->save($movie);

            $this->addManyGenres($imdbID, $searchedMovie->getGenres());
        });
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

        if (!is_null($userSubscription)) {
            $userSubscription->watch();
            return;
        }

        if (!is_null($movieRent)) {
            $movieRent->watch();

            $this->movieRentRepository->save($movieRent);
            return;
        }

        throw MovieApplicationException::movieIsNotAccessible();
    }

    /**
     * @throws MovieApplicationException
     */
    public function addManyGenres(IMDBID $IMDBID, array $genresName): void
    {
        $movie = $this->movieRepository->findByIMDBID($IMDBID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        $this->movieGenreRepository->removeByMovieID($movie->id);

        /** @var GenreName $name */
        foreach ($genresName as $name) {
            $genre = $this->genreRepository->findByName($name);
            if (is_null($genre)) {
                throw MovieApplicationException::invalidMovieGenreName();
            }

            $movieGenre = MovieGenre::new($movie->id, $genre->id);

            $this->movieGenreRepository->save($movieGenre);
        }
    }
}
