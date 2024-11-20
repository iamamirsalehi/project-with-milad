<?php

namespace App\Modules\Payment\Services\PaymentProviders;

use App\Modules\Payment\Enums\PaymentMethod;
use App\Modules\Payment\Exceptions\PaymentApplicationException;
use App\Modules\Payment\Services\PaymentProviders\PaymentMethods\MellatPayment;
use App\Modules\Payment\Services\PaymentProviders\PaymentMethods\SamanPayment;

class PaymentMethodFactory
{
    /**
     * @throws PaymentApplicationException
     */
    public function getFrom(PaymentMethod $paymentMethod): IPaymentMethod
    {
        $paymentMethodFactory = new PaymentMethodFactory();

        return match ($paymentMethod) {
            PaymentMethod::Mellat => $paymentMethodFactory->createMellatePaymentMethod(),
            PaymentMethod::Saman => $paymentMethodFactory->createSamanPaymentMethod(),
            default => throw PaymentApplicationException::invalidPaymentMethod()
        };
    }

    private function createMellatePaymentMethod(): IPaymentMethod
    {
        return new MellatPayment();
    }

    private function createSamanPaymentMethod(): IPaymentMethod
    {
        return new SamanPayment();
    }
}
