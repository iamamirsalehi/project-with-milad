<?php

namespace App\Modules\Movie\Models;

use App\Modules\Movie\Exceptions\MovieApplicationException;

readonly class MovieRentID
{
    /**
     * @throws MovieApplicationException
     */
    public function __construct(private int $id)
    {
        if ($this->id <= 0) {
            throw MovieApplicationException::invalidMovieRentID();
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
