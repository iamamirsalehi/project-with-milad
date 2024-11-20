<?php

namespace App\Modules\Payment\Services\PaymentProviders\PaymentMethods;

use App\Modules\Payment\Models\Amount;
use App\Modules\Payment\Services\PaymentProviders\IPaymentMethod;

class MellatPayment implements IPaymentMethod
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
}
