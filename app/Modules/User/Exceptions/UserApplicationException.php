<?php

namespace App\Modules\User\Exceptions;

use App\Contracts\Exceptions\BusinessException;

class UserApplicationException extends BusinessException
{
    private const INVALID_USER_ID = 'invalid user id';
    private const USER_DOES_NOT_EXIST = 'user does not exist';

    public static function invalidUserID(): self
    {
        return new self(self::INVALID_USER_ID);
    }

    public static function userDoesNotExist(): self
    {
        return new self(self::USER_DOES_NOT_EXIST);
    }
}
