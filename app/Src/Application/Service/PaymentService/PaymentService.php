<?php

namespace App\Src\Application\Service\PaymentService;

use App\Src\Domain\Exceptions\PaymentApplicationException;
use App\Src\Domain\Model\Payment\Payment;
use App\Src\Domain\Repository\IPaymentRepository;

final readonly class PaymentService
{
    public function __construct(
        private IPaymentRepository $paymentRepository,
        private PaymentRegistry    $paymentRegistry,
    )
    {
    }

    /**
     * @throws PaymentApplicationException
     */
    public function pay(NewPayment $newPayment): void
    {
        $payment = Payment::new(
            $newPayment->getUserID(),
            $newPayment->getAmount(),
            $newPayment->getPaymentableType(),
            $newPayment->getPaymentableID(),
            $newPayment->getPaymentMethod(),
        );

        $this->paymentRepository->save($payment);

        $this->paymentRegistry->resolve($newPayment->getPaymentMethod())->pay($newPayment->getAmount());
    }
}
