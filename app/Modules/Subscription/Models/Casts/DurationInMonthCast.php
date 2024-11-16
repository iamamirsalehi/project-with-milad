<?php

namespace App\Modules\Subscription\Models\Casts;

use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Subscription\Models\DurationInMonth;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class DurationInMonthCast implements CastsAttributes
{
    /**
     * @throws MovieApplicationException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): DurationInMonth
    {
        return new DurationInMonth($value);
    }

    /**
     * @throws MovieApplicationException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof DurationInMonth) {
            return $value->toPrimitiveType();
        }

        return (new DurationInMonth($value))->toPrimitiveType();
    }
}
