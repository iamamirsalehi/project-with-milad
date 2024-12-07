<?php

namespace App\Src\Instrastructure\Cast\Subscription;

use App\Src\Domain\Exceptions\MovieApplicationException;
use App\Src\Domain\Model\Subscription\DurationInMonth;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class DurationInMonthCast implements CastsAttributes
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
