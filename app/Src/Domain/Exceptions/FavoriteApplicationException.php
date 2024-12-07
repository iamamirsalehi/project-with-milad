<?php

namespace App\Src\Domain\Exceptions;

final class FavoriteApplicationException extends BusinessException
{
    private const INVALID_FAVORITE_ID = 'invalid favorite id';

    public static function invalidFavoriteID(): self
    {
        return new self(self::INVALID_FAVORITE_ID);
    }
}
