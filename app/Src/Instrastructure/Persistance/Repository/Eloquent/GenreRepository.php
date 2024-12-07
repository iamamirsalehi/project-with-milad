<?php

namespace App\Src\Instrastructure\Persistance\Repository\Eloquent;

use App\Src\Domain\Model\Movie\Genre;
use App\Src\Domain\Model\Movie\GenreName;
use App\Src\Domain\Repository\IGenreRepository;
use Illuminate\Support\Collection;

class GenreRepository extends EloquentBaseRepository implements IGenreRepository
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
