<?php

namespace App\Domain\Model\Favorite;

use App\Domain\Exceptions\FavoriteApplicationException;

final readonly class FavoriteID
{
    /**
     * @throws FavoriteApplicationException
     */
    public function __construct(private int $id)
    {
        if ($this->id <= 0) {
            throw FavoriteApplicationException::invalidFavoriteID();
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
