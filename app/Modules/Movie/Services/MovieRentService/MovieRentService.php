<?php

namespace App\Modules\Movie\Services\MovieRentService;

use App\Contracts\Repositories\IMovieRentRepository;
use App\Contracts\Repositories\IMovieRepository;
use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Movie\Models\MovieRent;
use App\Modules\Movie\Services\MovieService\NewMovieRent;
use App\Modules\Payment\Exceptions\PaymentApplicationException;

readonly class MovieRentService
{
    public function __construct(
        private IMovieRepository     $movieRepository,
        private IMovieRentRepository $movieRentRepository,
    )
    {
    }

    /**
     * @throws MovieApplicationException
     * @throws PaymentApplicationException
     */
    public function rent(NewMovieRent $data): void
    {
        $movie = $this->movieRepository->findByIMDBID($data->getIMDBID());
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
