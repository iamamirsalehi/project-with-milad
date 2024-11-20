<?php

namespace App\Modules\Payment\Models;

use App\Modules\Payment\Exceptions\PaymentApplicationException;

class InvoiceID
{
    /**
     * @throws PaymentApplicationException
     */
    public function __construct(private int $id)
    {
        if ($this->id <= 0){
            throw PaymentApplicationException::invalidInvoiceID();
        }
    }

    public function toPrimitiveType(): int
    {
        return $this->id;
    }

    public function __tostring(): string
    {
        return (string)$this->id;
    }
}
