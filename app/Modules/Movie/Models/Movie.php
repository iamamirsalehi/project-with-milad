<?php

namespace App\Modules\Movie\Models;

use App\Modules\Movie\Enums\MovieStatus;
use App\Modules\Movie\Exceptions\MovieApplicationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string $language
 * @property string $country
 * @property string $poster
 * @property string $url
 * @property-read MovieStatus $status
 * @property string $imdb_rating
 * @property string $imdb_id
 * @property string imdb_votes
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * */
class Movie extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'status' => MovieStatus::class,
        ];
    }

    /**
     * @throws MovieApplicationException
     */
    public static function new(
        string     $title,
        Language   $language,
        Country    $country,
        Poster     $poster,
        IMDBID     $imdbId,
        IMDBRating $imdbRating,
        IMDBVote   $imdbVotes,
    ): self
    {
        $newMovie = new self();
        $newMovie->title = $title;
        $newMovie->language = $language->get();
        $newMovie->country = $country->get();
        $newMovie->poster = $poster->get();
        $newMovie->imdb_id = $imdbId->get();
        $newMovie->imdb_rating = $imdbRating->get();
        $newMovie->imdb_votes = $imdbVotes->get();
        $newMovie->status = MovieStatus::Draft;

        return $newMovie;
    }

    public function isAvailable(): bool
    {
        return !is_null($this->url) && $this->status == MovieStatus::Published;
    }

    public function isDraft(): bool
    {
        return $this->status == MovieStatus::Draft;
    }

    public function isPublished(): bool
    {
        return $this->status == MovieStatus::Published;
    }

    public function hasVideo(): bool
    {
        return !is_null($this->url);
    }

    /**
     * @throws MovieApplicationException
     */
    public function publish(): void
    {
        if ($this->isPublished()) {
            throw MovieApplicationException::movieIsAlreadyPublished();
        }

        if (false === $this->hasVideo()) {
            throw MovieApplicationException::movieDoesNotHaveVideo();
        }

        $this->status = MovieStatus::Published;
    }

    /**
     * @throws MovieApplicationException
     */
    public function draft(): void
    {
        if ($this->isDraft()) {
            throw MovieApplicationException::movieIsAlreadyDraft();
        }

        $this->status = MovieStatus::Draft;
    }
}
