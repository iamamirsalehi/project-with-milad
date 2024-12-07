<?php

namespace App\Src\Instrastructure\Persistance\Repository\Eloquent;

use App\Src\Domain\Model\Movie\MovieGenre;
use App\Src\Domain\Model\Movie\MovieID;
use App\Src\Domain\Repository\IMovieGenreRepository;

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
