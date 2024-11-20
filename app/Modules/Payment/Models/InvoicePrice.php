<?php

namespace App\Modules\Payment\Models;

use App\Modules\Payment\Exceptions\PaymentApplicationException;

class InvoicePrice
{
    public function __construct(private int $price)
    {
        if($this->price <= 0){
            throw PaymentApplicationException::invalidInvoicePrice();
        }
    }

    public function toPrimitiveType(): int
    {
        return $this->price;
    }

    public function __tostring(): string
    {
        return (string)$this->price;
    }
}