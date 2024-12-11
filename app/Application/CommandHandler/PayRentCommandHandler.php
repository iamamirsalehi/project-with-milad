<?php

namespace App\Application\CommandHandler;

use App\Application\Command\PayRentCommand;
use App\Application\Service\MovieRentService\MovieRentService;
use App\Application\Service\MovieRentService\NewMovieRent;
use App\Application\Service\PaymentService\NewPayment;
use App\Application\Service\PaymentService\PaymentService;
use App\Domain\Exceptions\MovieApplicationException;
use App\Domain\Exceptions\PaymentApplicationException;
use App\Domain\Model\Payment\Amount;
use App\Domain\Model\Payment\PaymentableID;
use App\Domain\Model\Payment\PaymentableType;
use App\Domain\Repository\MovieRepository;
use App\Domain\Service\MovieRentPriceCalculation\MovieRentPriceCalculation;

final readonly class PayRentCommandHandler
{
    public function __construct(
        private MovieRepository           $movieRepository,
        private MovieRentService          $movieRentService,
        private MovieRentPriceCalculation $movieRentPriceCalculation,
        private PaymentService            $paymentService,
    )
    {

    }

    /**
     * @throws PaymentApplicationException
     * @throws MovieApplicationException
     */
    public function __invoke(PayRentCommand $payRentCommand): void
    {
        $movie = $this->movieRepository->findByIMDBID($payRentCommand->IMDBID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        $newMovieRent = new NewMovieRent(
            $movie->id,
            $payRentCommand->userID,
            $payRentCommand->duration,
        );

        $this->movieRentService->add($newMovieRent);

        $calculatedPrice = $this->movieRentPriceCalculation->calculate($payRentCommand->duration);

        $newPayment = new NewPayment(
            $payRentCommand->userID,
            new Amount($calculatedPrice->toPrimitiveType()),
            $payRentCommand->paymentMethod,
            new PaymentableType($movie),
            new PaymentableID($movie->id->toPrimitiveType()),
        );

        $this->paymentService->pay($newPayment);
    }
}
