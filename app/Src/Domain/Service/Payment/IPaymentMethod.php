<?php

namespace App\Src\Domain\Service\Payment;

use App\Src\Domain\Model\Payment\Amount;

interface IPaymentMethod
{
    public function getName(): string;

    public function pay(Amount $amount): bool;

    public function verify(): void;
}
