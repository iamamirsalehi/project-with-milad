<?php

namespace App\Modules\Payment\Services\PaymentProviders;

use App\Contracts\Resolver\IResolver;
use App\Modules\Payment\Exceptions\PaymentApplicationException;

final class PaymentRegistry
{
    /**
     * @throws PaymentApplicationException
     */
    public function __construct(
        private readonly IResolver $resolver,
        private array              $gateways)
    {
        foreach ($this->gateways as $gateway) {
            $this->register($gateway->getMethod());
        }
    }

    /**
     * @throws PaymentApplicationException
     */
    public function resolve(string $name): IPaymentMethod
    {
        if (!isset($this->gateways[$name])) {
            throw PaymentApplicationException::invalidPaymentMethod();
        }

        return $this->resolver->resolve($this->gateways[$name]);
    }

    private function register(IPaymentMethod $paymentMethod): void
    {
        $this->gateways[$paymentMethod->getName()] = $paymentMethod;
    }
}
