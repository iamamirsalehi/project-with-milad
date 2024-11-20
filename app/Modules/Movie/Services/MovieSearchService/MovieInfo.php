<?php

namespace App\Modules\Movie\Services\MovieSearchService;

use App\Modules\Movie\Models\Country;
use App\Modules\Movie\Models\IMDBID;
use App\Modules\Movie\Models\IMDBRating;
use App\Modules\Movie\Models\IMDBVote;
use App\Modules\Movie\Models\Language;
use App\Modules\Movie\Models\Poster;

readonly class MovieInfo
{
    public function __construct(
        private string     $title,
        private Language   $language,
        private Country    $country,
        private Poster     $poster,
        private IMDBRating $imdbRating,
        private IMDBID     $imdbID,
        private IMDBVote   $imdbVotes,
        private array      $genres,
    )
    {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getLanguage(): Language
    {
        return $this->language;
    }

    public function getCountry(): Country
    {
        return $this->country;
    }

    public function getPoster(): Poster
    {
        return $this->poster;
    }

    public function getImdbRating(): IMDBRating
    {
        return $this->imdbRating;
    }

    public function getImdbID(): IMDBID
    {
        return $this->imdbID;
    }

    public function getImdbVotes(): IMDBVote
    {
        return $this->imdbVotes;
    }

    public function getGenres(): array
    {
        return $this->genres;
    }
}
