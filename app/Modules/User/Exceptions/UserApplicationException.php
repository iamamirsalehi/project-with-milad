<?php

namespace App\Modules\User\Exceptions;

use App\Contracts\Exceptions\BusinessException;

class UserApplicationException extends BusinessException
{
    private const INVALID_USER_ID = 'invalid user id';

    public static function invalidUserID(): self
    {
        return new self(self::INVALID_USER_ID);
    }
}
