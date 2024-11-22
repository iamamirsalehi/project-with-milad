<?php

namespace App\Modules\Payment\Services\PaymentProviders;

use App\Contracts\Resolver\IResolver;
use App\Modules\Payment\Enums\PaymentMethod;
use App\Modules\Payment\Exceptions\PaymentApplicationException;

class PaymentRegistry
{
    protected array $gateways = [];

    public function __construct(private IResolver $resolver)
    {
    }

    /**
     * @throws PaymentApplicationException
     */
    public function register(PaymentMethod $method, string $class): void
    {
        if (!class_exists($class) || !is_subclass_of($class, IPaymentMethod::class)) {
            throw PaymentApplicationException::invalidPaymentMethod();
        }

        $this->gateways[$method->value] = $class;
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
}
