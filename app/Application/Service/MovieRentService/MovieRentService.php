<?php

namespace App\Application\Service\MovieRentService;

use App\Domain\Exceptions\MovieApplicationException;
use App\Domain\Model\Movie\MovieRent;
use App\Domain\Repository\MovieRentRepository;
use App\Domain\Repository\MovieRepository;

final readonly class MovieRentService
{
    public function __construct(
        private MovieRepository     $movieRepository,
        private MovieRentRepository $movieRentRepository,
    )
    {
    }

    /**
     * @throws MovieApplicationException
     */
    public function add(NewMovieRent $data): void
    {
        $movie = $this->movieRepository->findByID($data->getMovieID());
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        if (false === $movie->isAvailable()) {
            throw MovieApplicationException::movieIsNotAvailable();
        }

        $rentedMovie = $this->movieRentRepository->findLatestByUserIDAndMovieID($data->getUserID(), $movie->id);
        if (false === is_null($rentedMovie) && false === $rentedMovie->isExpired()) {
            throw MovieApplicationException::canNotHaveMoreThanTwoRentedMovie();
        }

        $rentedMovie = MovieRent::new($movie->id, $data->getUserID(), $data->getDuration());

        $this->movieRentRepository->save($rentedMovie);
    }
}
