<?php

namespace App\Infrastructure\Cast\Movie;

use App\Domain\Exceptions\MovieApplicationException;
use App\Domain\Model\Movie\GenreID;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class GenreIDCast implements CastsAttributes
{
    /**
     * @throws MovieApplicationException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): GenreID
    {
        return new GenreID($value);
    }

    /**
     * @throws MovieApplicationException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof GenreID) {
            return $value->toPrimitiveType();
        }

        return (new GenreID($value))->toPrimitiveType();
    }
}
