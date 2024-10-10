<?php

namespace App\Services\MovieSearch;

class MovieSearchDto
{
    private ?string $title = null;
    private ?string $imdbID = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getImdbID(): ?string
    {
        return $this->imdbID;
    }

    public function setImdbID(string $imdbID): void
    {
        $this->imdbID = $imdbID;
    }
}
