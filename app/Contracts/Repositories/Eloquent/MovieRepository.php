<?php

namespace App\Contracts\Repositories\Eloquent;

use App\Contracts\Repositories\IMovieRepository;
use App\Modules\Movie\Enums\MovieStatus;
use App\Modules\Movie\Models\Genre;
use App\Modules\Movie\Models\IMDBID;
use App\Modules\Movie\Models\Movie;
use Illuminate\Support\Collection;

class MovieRepository extends EloquentBaseRepository implements IMovieRepository
{
    public function exists(IMDBID $imdbID): bool
    {
        return $this->model->newQuery()->where('imdb_id', $imdbID)->exists();
    }

    public function save(Movie $movie): void
    {
        $movie->save();
    }

    public function findByIMDBID(IMDBID $imdbID): ?Movie
    {
        /** @var Movie $movie */
        $movie = $this->model->newQuery()
            ->with(['genres'])
            ->where('imdb_id', $imdbID)
            ->first();
        if (is_null($movie)) {
            return null;
        }

        return $movie;
    }

    public function all(MovieStatus $status = null, Genre $genre = null): Collection
    {
        $query = $this->model->newQuery()->with(['genres']);
        if ($status) {
            $query->where('status', $status);
        }

        if ($genre) {
            $query->whereHas('genres', function ($query) use ($genre) {
                $query->where('genre_id', $genre->id);
            });
        }

        return $query->get();
    }
}
