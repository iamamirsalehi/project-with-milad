<?php

namespace App\Application\Command;

use App\Domain\Model\Payment\PaymentID;

final readonly class VerifyPaymentCommand
{
    public function __construct(public PaymentID $paymentID)
    {

    }
}
