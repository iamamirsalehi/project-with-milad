<?php

namespace App\Src\Application\Service\PaymentService;

use App\Src\Domain\Exceptions\PaymentApplicationException;
use App\Src\Domain\Resolver\IResolver;
use App\Src\Domain\Service\Payment\IPaymentMethod;

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
