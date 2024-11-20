<?php

namespace App\Contracts\Repositories\Eloquent;

use App\Contracts\Repositories\IGenreRepository;
use App\Modules\Movie\Models\Genre;
use App\Modules\Movie\Models\GenreName;
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
}
