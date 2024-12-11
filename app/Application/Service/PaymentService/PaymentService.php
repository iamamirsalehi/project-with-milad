<?php

namespace App\Application\Service\PaymentService;

use App\Domain\Exceptions\PaymentApplicationException;
use App\Domain\Model\Payment\Payment;
use App\Domain\Repository\PaymentRepository;

final readonly class PaymentService
{
    public function __construct(
        private PaymentRepository $paymentRepository,
        private PaymentRegistry   $paymentRegistry,
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
