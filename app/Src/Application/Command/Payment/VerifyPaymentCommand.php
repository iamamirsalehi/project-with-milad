<?php

namespace App\Src\Application\Command\Payment;

use App\Src\Domain\Model\Payment\PaymentID;

final readonly class VerifyPaymentCommand
{
    public function __construct(public PaymentID $paymentID)
    {

    }
}
