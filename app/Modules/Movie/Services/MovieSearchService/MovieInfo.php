<?php

namespace App\Modules\Movie\Services\MovieSearchService;

readonly class MovieInfo
{
    public function __construct(
        private string $title,
        private string $language,
        private string $country,
        private string $poster,
        private string $imdbRating,
        private string $imdbID,
        private string $imdbVotes
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
