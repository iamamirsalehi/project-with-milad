<?php

namespace App\Services\MovieDataProvider;

class MovieDataProviderResultDto
{
    private string $title;
    private string $language;
    private string $country;
    private string $poster;
    private string $imdbRating;
    private string $imdbID;
    private string $imdbVotes;

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function setPoster(string $poster): void
    {
        $this->poster = $poster;
    }

    public function setImdbRating(string $imdbRating): void
    {
        $this->imdbRating = $imdbRating;
    }

    public function setImdbID(string $imdbID): void
    {
        $this->imdbID = $imdbID;
    }

    public function setImdbVotes(string $imdbVotes): void
    {
        $this->imdbVotes = $imdbVotes;
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
