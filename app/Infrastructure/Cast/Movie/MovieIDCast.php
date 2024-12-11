<?php

namespace App\Infrastructure\Cast\Movie;

use App\Domain\Exceptions\MovieApplicationException;
use App\Domain\Model\Movie\MovieID;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class MovieIDCast implements CastsAttributes
{
    /**
     * @throws MovieApplicationException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?MovieID
    {
        if (is_null($value)) {
            return null;
        }

        return new MovieID($value);
    }

    /**
     * @throws MovieApplicationException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if (is_null($value)) {
            return null;
        }

        if ($value instanceof MovieID) {
            return $value->toPrimitiveType();
        }

        return (new MovieID($value))->toPrimitiveType();
    }
}
