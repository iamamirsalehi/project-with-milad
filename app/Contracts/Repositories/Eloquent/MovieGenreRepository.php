<?php

namespace App\Contracts\Repositories\Eloquent;

use App\Contracts\Repositories\IMovieGenreRepository;
use App\Modules\Movie\Models\MovieGenre;
use App\Modules\Movie\Models\MovieID;

class MovieGenreRepository extends EloquentBaseRepository implements IMovieGenreRepository
{
    public function save(MovieGenre $movieGenre): void
    {
        $movieGenre->save();
    }

    public function removeByMovieID(MovieID $movieID): void
    {
        $this->model->newQuery()
            ->where('movie_id', $movieID)
            ->delete();
    }
}
