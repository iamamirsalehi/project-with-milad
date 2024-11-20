<?php

namespace App\Modules\Payment\Services\PaymentProviders\PaymentMethods;

use App\Modules\Payment\Models\Amount;
use App\Modules\Payment\Services\PaymentProviders\IPaymentMethod;

class SamanPayment implements IPaymentMethod
{
    public function pay(Amount $amount): bool
    {
        return true;
    }

    public function verify(): void
    {
        
    }
}
