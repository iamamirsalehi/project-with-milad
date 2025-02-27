<?php

namespace App\Domain\Model\Payment;

use App\Domain\Exceptions\PaymentApplicationException;
use App\Domain\Model\Movie\MovieRent;
use App\Domain\Model\Subscription\Subscription;
use Illuminate\Database\Eloquent\Model;

final class PaymentableType
{
    /**
     * @throws PaymentApplicationException
     */
    public function __construct(private Model $paymentable)
    {
        if (
            !$this->paymentable instanceof Subscription
            && !$this->paymentable instanceof MovieRent
        ) {
            throw PaymentApplicationException::invalidPaymentableType();
        }
    }

    public function toPrimitiveType(): Model
    {
        return $this->paymentable;
    }

    public function __tostring(): string
    {
        return $this->paymentable->getMorphClass();
    }
}
