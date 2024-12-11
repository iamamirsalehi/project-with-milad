<?php

namespace App\Infrastructure\Persistance\Repository\Eloquent;

use App\Domain\Model\Movie\Genre;
use App\Domain\Model\Movie\GenreName;
use App\Domain\Repository\GenreRepository;
use Illuminate\Support\Collection;

class EloquentGenreRepository extends EloquentBaseRepository implements GenreRepository
{
    public function findByName(GenreName $name): ?Genre
    {
        return $this->model->newQuery()
            ->where('name_en', $name)
            ->first();
    }

    public function all(): Collection
    {
        return $this->model->newQuery()->get();
    }

    public function save(Genre $genre): void
    {
        $genre->save();
    }
}
