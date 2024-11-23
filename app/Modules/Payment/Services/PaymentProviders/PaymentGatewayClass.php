<?php

namespace App\Modules\Payment\Services\PaymentProviders;

use App\Modules\Payment\Exceptions\PaymentApplicationException;

readonly class PaymentGatewayClass
{
    /**
     * @throws PaymentApplicationException
     */
    public function __construct(private string $class)
    {
        if (!class_exists($class) || !is_subclass_of($class, IPaymentMethod::class)) {
            throw PaymentApplicationException::invalidPaymentMethod();
        }
    }

    public function toPrimitiveType(): string
    {
        return $this->class;
    }

    public function __toString(): string
    {
        return $this->class;
    }
}
