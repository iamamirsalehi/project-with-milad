<?php

namespace App\Infrastructure\Cast\Movie;

use App\Domain\Exceptions\MovieApplicationException;
use App\Domain\Model\Movie\MovieURL;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class MovieUrlCast implements CastsAttributes
{
    /**
     * @throws MovieApplicationException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): MovieURL
    {
        return new MovieURL($value);
    }

    /**
     * @throws MovieApplicationException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof MovieURL) {
            return $value->toPrimitiveType();
        }

        return (new MovieURL($value))->toPrimitiveType();
    }
}
