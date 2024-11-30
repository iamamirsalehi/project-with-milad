<?php

namespace App\Modules\Subscription\Models\Casts;

use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Subscription\Models\Price;
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
