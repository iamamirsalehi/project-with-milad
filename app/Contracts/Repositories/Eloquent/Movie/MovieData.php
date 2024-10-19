<?php

namespace App\Contracts\Repositories\Eloquent\Movie;

use App\Contracts\Repositories\Dto\BaseCreateData;

class MovieData extends BaseCreateData
{
    public function __construct(
        private readonly string $title,
        private readonly string $language,
        private readonly string $country,
        private readonly string $poster,
        private readonly string $imdbRating,
        private readonly string $imdbID,
        private readonly string $imdbVotes,
    )
    {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getPoster(): string
    {
        return $this->poster;
    }

    public function getImdbRating(): string
    {
        return $this->imdbRating;
    }

    public function getImdbID(): string
    {
        return $this->imdbID;
    }

    public function getImdbVotes(): string
    {
        return $this->imdbVotes;
    }
}
