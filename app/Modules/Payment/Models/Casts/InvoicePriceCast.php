<?php

namespace App\Modules\Payment\Models\Casts;

use App\Modules\Payment\Exceptions\PaymentApplicationException;
use App\Modules\Payment\Models\InvoicePrice;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class InvoicePriceCast implements CastsAttributes
{
    /**
     * @throws PaymentApplicationException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): InvoicePrice
    {
        return new InvoicePrice($value);
    }

    /**
     * @throws PaymentApplicationException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof InvoicePrice) {
            return $value;
        }

        return (new InvoicePrice($value))->toPrimitiveType();
    }
}
