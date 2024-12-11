<?php

namespace App\Infrastructure\Cast\Movie;

use App\Domain\Exceptions\MovieApplicationException;
use App\Domain\Model\Movie\IMDBRating;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class IMDBRatingCast implements CastsAttributes
{
    /**
     * @throws MovieApplicationException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): IMDBRating
    {
        return new IMDBRating($value);
    }

    /**
     * @throws MovieApplicationException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof IMDBRating) {
            return $value->toPrimitiveType();
        }

        return (new IMDBRating($value))->toPrimitiveType();
    }
}
