<?php

namespace App\Src\Application\Service\MovieSearchService;

use App\Src\Domain\Model\Movie\Country;
use App\Src\Domain\Model\Movie\GenreName;
use App\Src\Domain\Model\Movie\IMDBID;
use App\Src\Domain\Model\Movie\IMDBRating;
use App\Src\Domain\Model\Movie\IMDBVote;
use App\Src\Domain\Model\Movie\Language;
use App\Src\Domain\Model\Movie\Poster;

final class MovieInfo
{
    private array $genres;

    public function __construct(
        private readonly string     $title,
        private readonly Language   $language,
        private readonly Country    $country,
        private readonly Poster     $poster,
        private readonly IMDBRating $imdbRating,
        private readonly IMDBID     $imdbID,
        private readonly IMDBVote   $imdbVotes,
        array                       $genresName,
    )
    {
        foreach ($genresName as $genreName) {
            $this->addGenre($genreName);
        }
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

    private function addGenre(GenreName $genreName): void
    {
        $this->genres[] = $genreName;
    }
}
