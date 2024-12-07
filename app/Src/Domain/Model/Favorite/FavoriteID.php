<?php

namespace App\Src\Domain\Model\Favorite;

use App\Src\Domain\Exceptions\FavoriteApplicationException;

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
