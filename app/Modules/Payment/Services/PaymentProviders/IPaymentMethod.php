<?php

namespace App\Modules\Payment\Services\PaymentProviders;

use App\Modules\Payment\Models\Amount;

interface IPaymentMethod
{
    public function getName(): string;

    public function pay(Amount $amount): bool;

    public function verify(): void;
}
