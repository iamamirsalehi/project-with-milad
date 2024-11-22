<?php

namespace App\Modules\Payment\Models;

use App\Modules\Payment\Exceptions\PaymentApplicationException;

readonly class PaymentableID
{
    /**
     * @throws PaymentApplicationException
     */
    public function __construct(private int $id)
    {
        if ($this->id <= 0) {
            throw PaymentApplicationException::invalidPaymentableId();
        }
    }

    public function toPrimitiveType(): int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return (string)$this->id;
    }
}
