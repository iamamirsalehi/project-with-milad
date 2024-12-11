<?php

namespace App\Infrastructure\Persistance\Repository\Eloquent;

use App\Domain\Enums\MovieStatus;
use App\Domain\Model\Movie\Genre;
use App\Domain\Model\Movie\IMDBID;
use App\Domain\Model\Movie\Movie;
use App\Domain\Model\Movie\MovieID;
use App\Domain\Repository\MovieRepository;
use Illuminate\Support\Collection;

class EloquentMovieRepository extends EloquentBaseRepository implements MovieRepository
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

    public function filter(MovieStatus $status = null, Genre $genre = null): Collection
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

    public function findByID(MovieID $id): ?Movie
    {
        return $this->model->newQuery()
            ->where('id', $id)
            ->first();
    }
}
