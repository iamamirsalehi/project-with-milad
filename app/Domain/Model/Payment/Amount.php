<?php

namespace App\Domain\Model\Payment;

use App\Domain\Exceptions\PaymentApplicationException;

final readonly class Amount
{
    /**
     * @throws PaymentApplicationException
     */
    public function __construct(private int $amount)
    {
        if ($this->amount <= 0) {
            throw PaymentApplicationException::invalidPaymentAmount();
        }
    }

    public function toPrimitiveType(): int
    {
        return $this->amount;
    }

    public function __toString(): string
    {
        return (string)$this->amount;
    }
}
