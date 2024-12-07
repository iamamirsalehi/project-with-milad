<?php

namespace App\Src\Instrastructure\Cast\Movie;

use App\Src\Domain\Exceptions\MovieApplicationException;
use App\Src\Domain\Model\Movie\ExpiresAt;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class ExpiresAtCast implements CastsAttributes
{
    /**
     * @throws MovieApplicationException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ExpiresAt
    {
        return new ExpiresAt($value);
    }

    /**
     * @throws MovieApplicationException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof ExpiresAt) {
            return $value->toCarbon();
        }

        return (new ExpiresAt($value))->toCarbon();
    }
}
