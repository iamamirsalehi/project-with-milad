<?php

namespace App\Src\Domain\Model\Movie;

use App\Src\Domain\Exceptions\MovieApplicationException;

final readonly class Poster
{
    /**
     * @throws MovieApplicationException
     */
    public function __construct(private string $poster)
    {
        if (false === filter_var($this->poster, FILTER_VALIDATE_URL)) {
            throw MovieApplicationException::invalidPosterURL();
        }
    }

    public function toPrimitiveType(): string
    {
        return $this->poster;
    }

    public function __toString(): string
    {
        return $this->toPrimitiveType();
    }
}
