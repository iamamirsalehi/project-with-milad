<?php

namespace App\Src\Instrastructure\Cast\Movie;

use App\Src\Domain\Model\Movie\Language;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class LanguageCast implements CastsAttributes
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
