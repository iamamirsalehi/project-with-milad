<?php

namespace App\Modules\Movie\Models\Casts;

use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Movie\Models\Duration;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class DurationCast implements CastsAttributes
{
    /**
     * @throws MovieApplicationException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): Duration
    {
        return new Duration($value);
    }

    /**
     * @throws MovieApplicationException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof Duration) {
            return $value->toPrimitiveType();
        }

        return (new Duration($value))->toPrimitiveType();
    }
}
