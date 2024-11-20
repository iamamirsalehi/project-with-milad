<?php

namespace App\Modules\Movie\Models;

use App\Modules\Movie\Enums\MovieStatus;
use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Movie\Models\Casts\CountryCast;
use App\Modules\Movie\Models\Casts\IMDBIDCast;
use App\Modules\Movie\Models\Casts\IMDBRatingCast;
use App\Modules\Movie\Models\Casts\IMDBVoteCast;
use App\Modules\Movie\Models\Casts\LanguageCast;
use App\Modules\Movie\Models\Casts\MovieIDCast;
use App\Modules\Movie\Models\Casts\PosterCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Carbon;

/**
 * @property MovieID $id
 * @property string $title
 * @property Language $language
 * @property Country $country
 * @property Poster $poster
 * @property string $url
 * @property-read MovieStatus $status
 * @property IMDBRating $imdb_rating
 * @property IMDBID $imdb_id
 * @property IMDBVote imdb_votes
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * */
class Movie extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
//            'id' => MovieIDCast::class,
            'language' => LanguageCast::class,
            'country' => CountryCast::class,
            'poster' => PosterCast::class,
            'imdb_id' => IMDBIDCast::class,
            'imdb_rating' => IMDBRatingCast::class,
            'imdb_vote' => IMDBVoteCast::class,
            'status' => MovieStatus::class,
        ];
    }

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
        $newMovie->language = $language;
        $newMovie->country = $country;
        $newMovie->poster = $poster;
        $newMovie->imdb_id = $imdbId;
        $newMovie->imdb_rating = $imdbRating;
        $newMovie->imdb_votes = $imdbVotes;
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

    public function genres(): HasManyThrough
    {
        return $this->hasManyThrough(Genre::class, MovieGenre::class, 'movie_id', 'id');
    }
}
