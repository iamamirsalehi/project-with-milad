<?php

namespace App\Contracts\Repositories\Eloquent\Movie;

use App\Contracts\Repositories\Dto\BaseResult;

class MovieResult extends BaseResult
{
    public function __construct(
        private readonly int    $id,
        private readonly string $title,
        private readonly string $language,
        private readonly string $country,
        private readonly string $poster,
        private readonly string $imdbRating,
        private readonly string $imdbID,
        private readonly string $imdbVotes,
        private readonly ?string $url = null,
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
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

    public function getUrl(): ?string
    {
        return $this->url;
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
