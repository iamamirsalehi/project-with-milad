<?php

namespace App\Infrastructure\Cast\Payment;

use App\Domain\Exceptions\PaymentApplicationException;
use App\Domain\Model\Payment\PaymentID;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class PaymentIDCast implements CastsAttributes
{
    /**
     * @throws PaymentApplicationException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): PaymentID
    {
        return new PaymentID($value);
    }

    /**
     * @throws PaymentApplicationException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof PaymentID) {
            return $value->toPrimitiveType();
        }

        return (new PaymentID($value))->toPrimitiveType();
    }
}
