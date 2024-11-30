<?php

namespace App\Modules\Movie\Models;

use App\Modules\Movie\Exceptions\MovieApplicationException;

final readonly class GenreName
{
    /**
     * @throws MovieApplicationException
     */
    public function __construct(private string $genre)
    {
        if (empty($this->genre)) {
            throw MovieApplicationException::invalidMovieGenreName();
        }
    }

    public function toPrimitiveType(): string
    {
        return $this->genre;
    }

    public function __toString(): string
    {
        return $this->toPrimitiveType();
    }
}
