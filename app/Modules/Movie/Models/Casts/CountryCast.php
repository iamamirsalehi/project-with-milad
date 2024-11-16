<?php

namespace App\Modules\Movie\Models\Casts;

use App\Modules\Movie\Models\Country;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class CountryCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): Country
    {
        return new Country($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof Country) {
            return $value->toPrimitiveType();
        }

        return (new Country($value))->toPrimitiveType();
    }
}
