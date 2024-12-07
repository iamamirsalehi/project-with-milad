<?php

namespace App\Src\Application\CommandHandler\Payment;

use App\Src\Application\Command\Payment\PayRentCommand;
use App\Src\Application\Service\MovieRentService\MovieRentService;
use App\Src\Application\Service\MovieRentService\NewMovieRent;
use App\Src\Application\Service\PaymentService\NewPayment;
use App\Src\Application\Service\PaymentService\PaymentService;
use App\Src\Domain\Exceptions\MovieApplicationException;
use App\Src\Domain\Exceptions\PaymentApplicationException;
use App\Src\Domain\Model\Payment\Amount;
use App\Src\Domain\Model\Payment\PaymentableID;
use App\Src\Domain\Model\Payment\PaymentableType;
use App\Src\Domain\Repository\IMovieRepository;
use App\Src\Domain\Service\MovieRentPriceCalculation\MovieRentPriceCalculation;

final readonly class PayRentCommandHandler
{
    public function __construct(
        private IMovieRepository          $movieRepository,
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
