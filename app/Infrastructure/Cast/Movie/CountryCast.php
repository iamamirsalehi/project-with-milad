<?php

namespace App\Infrastructure\Cast\Movie;

use App\Domain\Model\Movie\Country;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class CountryCast implements CastsAttributes
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
