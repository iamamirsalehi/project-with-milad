<?php

namespace App\Modules\User\Models;

use App\Modules\User\Exceptions\UserApplicationException;

readonly class UserID
{
    public function __construct(private int $id)
    {
        if ($this->id <= 0) {
            throw UserApplicationException::invalidUserID();
        }
    }

    public function toPrimitiveType(): int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->toPrimitiveType();
    }
}
