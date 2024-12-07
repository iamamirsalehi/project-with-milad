<?php

namespace App\Src\Instrastructure\Service\PaymentMethods;

use App\Src\Domain\Model\Payment\Amount;
use App\Src\Domain\Service\Payment\IPaymentMethod;

final class SamanPayment implements IPaymentMethod
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
