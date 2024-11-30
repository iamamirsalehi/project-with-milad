<?php

namespace App\Modules\Movie\Models\Casts;

use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Movie\Models\IMDBID;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class IMDBIDCast implements CastsAttributes
{
    /**
     * @throws MovieApplicationException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): IMDBID
    {
        return new IMDBID($value);
    }

    /**
     * @throws MovieApplicationException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof ImdbId) {
            return $value->toPrimitiveType();
        }

        return (new IMDBID($value))->toPrimitiveType();
    }
}
