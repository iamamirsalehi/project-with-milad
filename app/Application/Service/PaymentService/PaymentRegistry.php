<?php

namespace App\Application\Service\PaymentService;

use App\Domain\Exceptions\PaymentApplicationException;
use App\Domain\Resolver\Resolver;
use App\Domain\Service\Payment\PaymentMethod;

final class PaymentRegistry
{
    /**
     * @throws PaymentApplicationException
     */
    public function __construct(
        private readonly Resolver $resolver,
        private array             $gateways)
    {
        foreach ($this->gateways as $gateway) {
            $this->register($gateway->getMethod());
        }
    }

    /**
     * @throws PaymentApplicationException
     */
    public function resolve(string $name): PaymentMethod
    {
        if (!isset($this->gateways[$name])) {
            throw PaymentApplicationException::invalidPaymentMethod();
        }

        return $this->resolver->resolve($this->gateways[$name]);
    }

    private function register(PaymentMethod $paymentMethod): void
    {
        $this->gateways[$paymentMethod->getName()] = $paymentMethod;
    }
}
