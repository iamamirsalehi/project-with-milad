<?php

namespace App\Contracts\Repositories\Eloquent;

use App\Contracts\Repositories\IMovieRepository;
use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Movie\Models\IMDBID;
use App\Modules\Movie\Models\Movie;

class MovieRepository extends EloquentBaseRepository implements IMovieRepository
{
    public function exists(string $imdbID): bool
    {
        return $this->model->newQuery()->where('imdb_id', $imdbID)->exists();
    }

    public function save(Movie $movie): void
    {
        $movie->save();
    }

    /**
     * @throws MovieApplicationException
     */
    public function findByIMDBID(IMDBID $imdbID): ?Movie
    {
        /** @var Movie $movie */
        $movie = $this->model->newQuery()->where('imdb_id', $imdbID->get())->first();
        if (is_null($movie)) {
            return null;
        }

        return $movie;
    }
}
