<?php

namespace App\Modules\Payment\Services\PaymentService;

use App\Contracts\Repositories\IMovieRepository;
use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Movie\Services\MovieRentService\MovieRentPriceCalculation;
use App\Modules\Movie\Services\MovieRentService\MovieRentService;
use App\Modules\Movie\Services\MovieService\NewMovieRent;
use App\Modules\Payment\Exceptions\PaymentApplicationException;
use App\Modules\Payment\Models\Amount;
use App\Modules\Payment\Models\PaymentableID;
use App\Modules\Payment\Models\PaymentableType;

readonly class MovieRentPaymentService
{
    public function __construct(
        private IMovieRepository          $movieRepository,
        private MovieRentPriceCalculation $movieRentPriceCalculation,
        private MovieRentService          $movieRentService,
        private PaymentService            $paymentService,
    )
    {
    }

    /**
     * @throws MovieApplicationException
     * @throws PaymentApplicationException
     */
    public function pay(NewMovieRentPayment $data): void
    {
        $movie = $this->movieRepository->findByIMDBID($data->getIMDBID());
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        $newMovieRent = new NewMovieRent(
            $movie->id,
            $data->getUserID(),
            $data->getDuration(),
        );

        $this->movieRentService->add($newMovieRent);

        $calculatedPrice = $this->movieRentPriceCalculation->calculate($data->getDuration());

        $newPayment = new NewPayment(
            $data->getUserID(),
            new Amount($calculatedPrice->toPrimitiveType()),
            $data->getPaymentMethod(),
            new PaymentableType($movie),
            new PaymentableID($movie->id->toPrimitiveType()),
        );

        $this->paymentService->pay($newPayment);
    }
}
