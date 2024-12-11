<?php

namespace App\Domain\Model\Payment;

use App\Domain\Exceptions\PaymentApplicationException;

final readonly class PaymentID
{
    /**
     * @throws PaymentApplicationException
     */
    public function __construct(private int $id)
    {
        if ($this->id <= 0) {
            throw PaymentApplicationException::invalidPaymentID();
        }
    }

    public function toPrimitiveType(): int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->toPrimitiveType();
    }
}
