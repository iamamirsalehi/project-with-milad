<?php

namespace App\Infrastructure\Service\PaymentMethods;

use App\Domain\Model\Payment\Amount;
use App\Domain\Service\Payment\PaymentMethod;

final class SamanPayment implements PaymentMethod
{
    public function pay(Amount $amount): bool
    {
        return true;
    }

    public function verify(): void
    {

    }

    public function getName(): string
    {
        return 'saman';
    }
}
