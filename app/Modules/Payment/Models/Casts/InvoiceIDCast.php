<?php

namespace App\Modules\Payment\Models\Casts;

use App\Modules\Payment\Exceptions\PaymentApplicationException;
use App\Modules\Payment\Models\InvoiceID;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class InvoiceIDCast implements CastsAttributes
{
    /**
     * @throws PaymentApplicationException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): InvoiceID
    {
        return new InvoiceID($value);
    }

    /**
     * @throws PaymentApplicationException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof InvoiceID) {
            return $value->toPrimitiveType();
        }

        return (new InvoiceID($value))->toPrimitiveType();
    }
}
