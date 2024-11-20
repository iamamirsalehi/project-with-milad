<?php

namespace App\Modules\Movie\Services\MovieRentService;

use App\Contracts\Repositories\IMovieRentRepository;
use App\Contracts\Repositories\IMovieRepository;
use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Movie\Models\Duration;
use App\Modules\Movie\Models\MovieRent;
use App\Modules\Movie\Services\MovieService\NewMovieRent;
use App\Modules\Payment\Enums\InvoiceType;
use App\Modules\Payment\Exceptions\PaymentApplicationException;
use App\Modules\Payment\Models\InvoiceID;
use App\Modules\Payment\Models\InvoicePrice;
use App\Modules\Payment\Models\InvoiceTypeID;
use App\Modules\Payment\Services\InvoiceService\InvoiceService;
use App\Modules\Payment\Services\InvoiceService\NewInvoice;

readonly class MovieRentService
{
    private const BASE_RENT_FEE = 5000;
    private const ADDITIONAL_COST_PER_DAY = 3000;

    public function __construct(
        private IMovieRepository     $movieRepository,
        private IMovieRentRepository $movieRentRepository,
        private InvoiceService       $invoiceService,
    )
    {
    }

    /**
     * @throws MovieApplicationException
     * @throws PaymentApplicationException
     */
    public function rent(NewMovieRent $data): InvoiceID
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

        $savedMovieRent = $this->movieRentRepository->findLatestByUserIDAndMovieID($data->getUserID(), $movie->id);

        $newInvoice = new NewInvoice(
            $data->getUserID(),
            InvoiceType::Rent,
            new InvoiceTypeID($savedMovieRent->id->toPrimitiveType()),
            new InvoicePrice($this->calculateRentFee($data->getDuration()))
        );

        return $this->invoiceService->add($newInvoice);
    }

    private function calculateRentFee(Duration $duration): int
    {
        return self::BASE_RENT_FEE + ($duration->toPrimitiveType() - 1) * self::ADDITIONAL_COST_PER_DAY;
    }
}
