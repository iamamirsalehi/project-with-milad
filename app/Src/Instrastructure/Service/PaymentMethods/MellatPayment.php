<?php

namespace App\Src\Instrastructure\Service\PaymentMethods;

use App\Src\Domain\Model\Payment\Amount;
use App\Src\Domain\Service\Payment\IPaymentMethod;

final class MellatPayment implements IPaymentMethod

{
    public function __construct()
    {

    }

    public function pay(Amount $amount): bool
    {
        return true;
    }

    public function verify(): void
    {

    }

    public function getName(): string
    {
        return 'mellat';
    }
}
