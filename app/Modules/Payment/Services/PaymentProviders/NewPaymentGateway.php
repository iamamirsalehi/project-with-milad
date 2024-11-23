<?php

namespace App\Modules\Payment\Services\PaymentProviders;

use App\Modules\Payment\Enums\PaymentMethod;

readonly class NewPaymentGateway
{
    public function __construct(
        private PaymentMethod $method,
        private PaymentGatewayClass $class
    )
    {
    }

    public function getMethod(): PaymentMethod
    {
        return $this->method;
    }

    public function getClass(): PaymentGatewayClass
    {
        return $this->class;
    }
}
