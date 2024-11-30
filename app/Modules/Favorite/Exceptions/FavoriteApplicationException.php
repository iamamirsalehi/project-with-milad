<?php

namespace App\Modules\Favorite\Exceptions;

use App\Contracts\Exceptions\BusinessException;

final class FavoriteApplicationException extends BusinessException
{
    private const INVALID_FAVORITE_ID = 'invalid favorite id';

    public static function invalidFavoriteID(): self
    {
        return new self(self::INVALID_FAVORITE_ID);
    }
}
