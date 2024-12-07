<?php

namespace App\Src\Application\CommandHandler\Payment;

use App\Src\Application\Command\Payment\VerifyPaymentCommand;
use App\Src\Application\Events\PaidEvent;
use App\Src\Domain\Exceptions\PaymentApplicationException;
use App\Src\Domain\Repository\IPaymentRepository;
use Illuminate\Contracts\Events\Dispatcher;

final readonly class VerifyPaymentCommandHandler
{
    public function __construct(
        private IPaymentRepository $paymentRepository,
        private Dispatcher         $dispatcher,
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
