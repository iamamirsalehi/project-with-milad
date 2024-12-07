<?php

namespace App\Src\Application\Service\MovieRentService;

use App\Src\Domain\Exceptions\MovieApplicationException;
use App\Src\Domain\Model\Movie\MovieRent;
use App\Src\Domain\Repository\IMovieRentRepository;
use App\Src\Domain\Repository\IMovieRepository;

final readonly class MovieRentService
{
    public function __construct(
        private IMovieRepository          $movieRepository,
        private IMovieRentRepository      $movieRentRepository,
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
