<?php

namespace App\Domain\Model\Movie;

use App\Domain\Exceptions\MovieApplicationException;

final readonly class MovieGenreID
{
    /**
     * @throws MovieApplicationException
     */
    public function __construct(private int $id)
    {
        if ($this->id <= 0) {
            throw MovieApplicationException::invalidMovieGenreID();
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
