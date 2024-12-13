<?php

namespace App\Domain\Model\Movie;

use App\Domain\Exceptions\MovieApplicationException;

class MovieURL
{
    /**
     * @throws MovieApplicationException
     */
    public function __construct(private string $url)
    {
        if (filter_var($this->url, FILTER_VALIDATE_URL) === false) {
            throw MovieApplicationException::invalidMovieUrl();
        }
    }

    public function toPrimitiveType(): string
    {

    }

    public function __toString(): string
    {
        return $this->url;
    }
}
