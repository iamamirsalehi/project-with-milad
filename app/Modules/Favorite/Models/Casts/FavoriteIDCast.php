<?php

namespace App\Modules\Favorite\Models\Casts;

use App\Modules\Favorite\Exceptions\FavoriteApplicationException;
use App\Modules\Favorite\Models\FavoriteID;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class FavoriteIDCast implements CastsAttributes
{
    /**
     * @throws FavoriteApplicationException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): FavoriteID
    {
        return new FavoriteID($value);
    }

    /**
     * @throws FavoriteApplicationException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof FavoriteID) {
            return $value->toPrimitiveType();
        }

        return (new FavoriteID($value))->toPrimitiveType();
    }
}
