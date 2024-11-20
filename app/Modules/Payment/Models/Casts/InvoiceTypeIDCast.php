<?php

namespace App\Modules\Payment\Models\Casts;

use App\Modules\Payment\Exceptions\PaymentApplicationException;
use App\Modules\Payment\Models\InvoiceTypeID;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class InvoiceTypeIDCast implements CastsAttributes
{
    /**
     * @throws PaymentApplicationException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): InvoiceTypeID
    {
        return new InvoiceTypeID($value);
    }

    /**
     * @throws PaymentApplicationException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof InvoiceTypeID) {
            return $value;
        }

        return (new InvoiceTypeID($value))->toPrimitiveType();
    }
}
