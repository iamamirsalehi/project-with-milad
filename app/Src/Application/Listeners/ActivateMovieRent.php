<?php

namespace App\Src\Application\Listeners;

use App\Src\Application\Events\PaidEvent;
use App\Src\Application\Service\MovieRentService\MovieRentService;
use App\Src\Domain\Exceptions\MovieApplicationException;
use App\Src\Domain\Model\Movie\MovieID;
use App\Src\Domain\Model\Movie\MovieRent;
use Illuminate\Contracts\Queue\ShouldQueue;

final readonly class ActivateMovieRent implements ShouldQueue
{
    public function __construct(
        private MovieRentService $movieRentService,
    )
    {
    }

    /**
     * @throws MovieApplicationException
     */
    public function handle(PaidEvent $paidEvent): void
    {
        $payment = $paidEvent->payment;

        if ($payment->paymentable_type->toPrimitiveType() != (new MovieRent())->getMorphClass()) {
            return;
        }

        $this->movieRentService->activate($payment->user_id, new MovieID($payment->paymentable_id->toPrimitiveType()));
    }
}
