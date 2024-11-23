<?php

namespace App\Modules\Payment\Services\PaymentProviders;

use App\Contracts\Resolver\IResolver;
use App\Modules\Payment\Enums\PaymentMethod;
use App\Modules\Payment\Exceptions\PaymentApplicationException;

class PaymentRegistry
{
    /**
     * @throws PaymentApplicationException
     */
    public function __construct(
        private readonly IResolver $resolver,
        private array              $gateways)
    {
        foreach ($this->gateways as $gateway) {
            $this->register($gateway->getMethod(), $gateway->getClass());
        }
    }

    /**
     * @throws PaymentApplicationException
     */
    public function resolve(PaymentMethod $method): IPaymentMethod
    {
        if (!isset($this->gateways[$method->value])) {
            throw PaymentApplicationException::invalidPaymentMethod();
        }

        return $this->resolver->resolve($this->gateways[$method->value]);
    }

    private function register(PaymentMethod $method, PaymentGatewayClass $class): void
    {
        $this->gateways[$method->value] = $class->toPrimitiveType();
    }
}
