<?php

namespace App\Contracts\Repositories\Eloquent\Movie;

use App\Contracts\Repositories\Dto\BaseCreateData;
use App\Contracts\Repositories\Eloquent\BaseRepository;
use App\Contracts\Repositories\IMovieRepository;
use App\Modules\Movie\Enums\MovieStatus;
use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Movie\Models\Movie;

class MovieRepository extends BaseRepository implements IMovieRepository
{
    public function exists(string $imdbID): bool
    {
        return $this->model->newQuery()->where('imdb_id', $imdbID)->exists();
    }

    /**
     * @var MovieData $data
     */
    public function create(BaseCreateData $data): MovieResult
    {
        /** @var Movie $movie */
        $movie = $this->model->newQuery()->create([
            'title' => $data->getTitle(),
            'language' => $data->getLanguage(),
            'country' => $data->getCountry(),
            'poster' => $data->getPoster(),
            'imdb_rating' => $data->getImdbRating(),
            'imdb_votes' => $data->getImdbVotes(),
            'imdb_id' => $data->getImdbId(),
            'status' => MovieStatus::Draft,
        ]);

        return new MovieResult(
            $movie->id,
            $movie->title,
            $movie->language,
            $movie->country,
            $movie->poster,
            $movie->imdb_rating,
            $movie->imdb_id,
            $movie->imdb_votes,
            $movie->status,
            $movie->url,
        );
    }

    public function findByIMDBID(string $imdbID): ?MovieResult
    {
        /** @var Movie $movie */
        $movie = $this->model->newQuery()->where('imdb_id', $imdbID)->first();
        if (is_null($movie)) {
            return null;
        }

        return new MovieResult(
            $movie->id,
            $movie->title,
            $movie->language,
            $movie->country,
            $movie->poster,
            $movie->imdb_rating,
            $movie->imdb_id,
            $movie->imdb_votes,
            $movie->status,
            $movie->url,
        );
    }

    /**
     * @throws MovieApplicationException
     */
    public function updateURL(string $imdbID, string $url): void
    {
        $updated = $this->model->newQuery()->where('imdb_id', $imdbID)->update([
            'url' => $url,
        ]);

        if (false == $updated) {
            throw MovieApplicationException::couldNotUpdateMovieURL();
        }
    }

    public function changeStatusToPublished(string $imdbID): void
    {
        $updated = $this->model->newQuery()->where('imdb_id', $imdbID)->update([
            'status' => MovieStatus::Published,
        ]);

        if (false == $updated) {
            throw MovieApplicationException::couldNotChangeStatus();
        }
    }

    public function changeStatusToDraft(string $imdbID): void
    {
        $updated = $this->model->newQuery()->where('imdb_id', $imdbID)->update([
            'status' => MovieStatus::Draft,
        ]);

        if (false == $updated) {
            throw MovieApplicationException::couldNotChangeStatus();
        }
    }
}
