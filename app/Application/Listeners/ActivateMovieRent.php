<?php

namespace App\Application\Listeners;

use App\Application\Command\ActivateMovieRentCommand;
use App\Domain\Events\PaidEvent;
use App\Domain\Exceptions\MovieApplicationException;
use App\Domain\Model\Movie\MovieID;
use App\Domain\Model\Movie\MovieRent;
use App\Infrastructure\CommandBus\CommandBus;
use Illuminate\Contracts\Queue\ShouldQueue;

final readonly class ActivateMovieRent implements ShouldQueue
{
    public function __construct(
        private CommandBus $commandBus,
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

        $this->commandBus->handle(new ActivateMovieRentCommand(
            new MovieID($payment->paymentable_id->toPrimitiveType()), $payment->user_id,
        ));
    }
}
