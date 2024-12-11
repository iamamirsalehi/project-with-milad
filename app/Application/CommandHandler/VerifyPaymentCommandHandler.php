<?php

namespace App\Application\CommandHandler;

use App\Application\Command\VerifyPaymentCommand;
use App\Domain\Events\PaidEvent;
use App\Domain\Exceptions\PaymentApplicationException;
use App\Domain\Repository\PaymentRepository;
use Illuminate\Contracts\Events\Dispatcher;

final readonly class VerifyPaymentCommandHandler
{
    public function __construct(
        private PaymentRepository $paymentRepository,
        private Dispatcher        $dispatcher,
    )
    {
    }

    /**
     * @throws PaymentApplicationException
     */
    public function __invoke(VerifyPaymentCommand $verifyPaymentCommand): void
    {
        $payment = $this->paymentRepository->findByID($verifyPaymentCommand->paymentID);
        if (is_null($payment)) {
            throw PaymentApplicationException::invalidPaymentID();
        }

        $payment->pay();

        $this->paymentRepository->save($payment);

        $this->dispatcher->dispatch(new PaidEvent($payment));
    }
}
