<?php

namespace App\Infrastructure\Persistance\Repository\Eloquent;

use App\Domain\Model\Movie\MovieGenre;
use App\Domain\Model\Movie\MovieID;
use App\Domain\Repository\MovieGenreRepository;

class EloquentMovieGenreRepository extends EloquentBaseRepository implements MovieGenreRepository
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
