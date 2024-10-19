<?php

namespace App\Contracts\Repositories\Eloquent\Movie;

use App\Contracts\Repositories\Dto\BaseCreateData;
use App\Contracts\Repositories\Eloquent\BaseRepository;
use App\Contracts\Repositories\IMovieRepository;
use App\Models\Movie;

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
            $movie->url,
        );
    }
}
