<?php

namespace App\Modules\Movie\Services\MovieRentService;

use App\Contracts\Repositories\IMovieRentRepository;
use App\Contracts\Repositories\IMovieRepository;
use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Movie\Models\MovieRent;
use App\Modules\Movie\Services\MovieService\NewMovieRent;

readonly class MovieRentService
{
    public function __construct(
        private IMovieRepository          $movieRepository,
        private IMovieRentRepository      $movieRentRepository,
        private MovieRentPriceCalculation $movieRentPriceCalculation,
    )
    {
    }

    /**
     * @throws MovieApplicationException
     */
    public function rent(NewMovieRent $data): void
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

        $calculatedDuration = $this->movieRentPriceCalculation->calculate($data->getDuration());

        $rentedMovie = MovieRent::new($movie->id, $data->getUserID(), $calculatedDuration);

        $this->movieRentRepository->save($rentedMovie);
    }
}
