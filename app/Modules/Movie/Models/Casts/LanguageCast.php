<?php

namespace App\Modules\Movie\Models\Casts;

use App\Modules\Movie\Models\Language;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class LanguageCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): Language
    {
        return new Language($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof Language) {
            return $value->toPrimitiveType();
        }

        return (new Language($value))->toPrimitiveType();
    }
}
