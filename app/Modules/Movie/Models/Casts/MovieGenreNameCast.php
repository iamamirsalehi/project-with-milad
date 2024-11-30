<?php

namespace App\Modules\Movie\Models\Casts;

use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Movie\Models\GenreName;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class MovieGenreNameCast implements CastsAttributes
{
    /**
     * @throws MovieApplicationException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): GenreName
    {
        return new GenreName($value);
    }

    /**
     * @throws MovieApplicationException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof GenreName) {
            return $value->toPrimitiveType();
        }

        return (new GenreName($value))->toPrimitiveType();
    }
}
