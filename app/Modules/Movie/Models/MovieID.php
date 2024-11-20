<?php

namespace App\Modules\Movie\Models;

use App\Modules\Movie\Exceptions\MovieApplicationException;

readonly class MovieID
{
    /**
     * @throws MovieApplicationException
     */
    public function __construct(private int $id)
    {
        if ($this->id <= 0) {
            throw MovieApplicationException::invalidMovieID();
        }
    }

    public function toPrimitiveType(): int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return (string)$this->id;
    }
}
