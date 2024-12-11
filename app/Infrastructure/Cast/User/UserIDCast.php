<?php

namespace App\Infrastructure\Cast\User;

use App\Domain\Exceptions\UserApplicationException;
use App\Domain\Model\User\UserID;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class UserIDCast implements CastsAttributes
{
    /**
     * @throws UserApplicationException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): UserID
    {
        return new UserID($value);
    }

    /**
     * @throws UserApplicationException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof UserID) {
            return $value->toPrimitiveType();
        }

        return (new UserID($value))->toPrimitiveType();
    }
}
