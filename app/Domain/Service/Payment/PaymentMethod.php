<?php

namespace App\Domain\Service\Payment;

use App\Domain\Model\Payment\Amount;

interface PaymentMethod
{
    public function getName(): string;

    public function pay(Amount $amount): bool;

    public function verify(): void;
}
