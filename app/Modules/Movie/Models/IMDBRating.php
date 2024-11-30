<?php

namespace App\Modules\Movie\Models;

use App\Modules\Movie\Exceptions\MovieApplicationException;

final readonly class IMDBRating
{
    /**
     * @throws MovieApplicationException
     */
    public function __construct(private float $IMDBRating)
    {
        if ($this->IMDBRating < 0 || $this->IMDBRating > 10) {
            throw MovieApplicationException::iMDBRatingMustBeBetween0And10();
        }
    }

    public function toPrimitiveType(): float
    {
        return $this->IMDBRating;
    }

    public function __toString(): string
    {
        return $this->toPrimitiveType();
    }
}
