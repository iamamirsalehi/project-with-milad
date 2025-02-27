<?php

namespace App\Infrastructure\Cast\Movie;

use App\Domain\Exceptions\MovieApplicationException;
use App\Domain\Model\Movie\Poster;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class PosterCast implements CastsAttributes
{
    /**
     * @throws MovieApplicationException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): Poster
    {
        return new Poster($value);
    }

    /**
     * @throws MovieApplicationException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof Poster) {
            return $value->toPrimitiveType();
        }

        return (new Poster($value))->toPrimitiveType();
    }
}
