<?php

namespace App\Infrastructure\Cast\Subscription;

use App\Domain\Exceptions\MovieApplicationException;
use App\Domain\Model\Subscription\Price;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class PriceCast implements CastsAttributes
{
    /**
     * @throws MovieApplicationException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): Price
    {
        return new Price($value);
    }

    /**
     * @throws MovieApplicationException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof Price) {
            return $value->toPrimitiveType();
        }

        return (new Price($value))->toPrimitiveType();
    }
}
