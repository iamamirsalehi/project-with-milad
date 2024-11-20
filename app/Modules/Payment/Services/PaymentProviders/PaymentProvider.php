<?php

namespace App\Modules\Payment\Services\PaymentProviders;

use App\Modules\Payment\Models\Amount;

class PaymentProvider
{
    public function __construct(private IPaymentMethod $paymentMethod)
    {
    }

    public function pay(Amount $amount): bool
    {
        return $this->paymentMethod->pay($amount);
    }

    public function verify(): void
    {
        $this->paymentMethod->verify();
    }

    public function setPaymentMethod(IPaymentMethod $paymentMethod): void
    {
        $this->paymentMethod = $paymentMethod;
    }
}
