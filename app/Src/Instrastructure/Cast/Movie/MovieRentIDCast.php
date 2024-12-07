<?php

namespace App\Src\Instrastructure\Cast\Movie;

use App\Src\Domain\Exceptions\MovieApplicationException;
use App\Src\Domain\Model\Movie\MovieRentID;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class MovieRentIDCast implements CastsAttributes
{
    /**
     * @throws MovieApplicationException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): MovieRentID
    {
        return new MovieRentID($value);
    }

    /**
     * @throws MovieApplicationException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof MovieRentID) {
            return $value->toPrimitiveType();
        }

        return (new MovieRentID($value))->toPrimitiveType();
    }
}
