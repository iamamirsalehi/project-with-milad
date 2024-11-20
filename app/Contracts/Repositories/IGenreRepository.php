<?php

namespace App\Contracts\Repositories;

use App\Modules\Movie\Models\Genre;
use App\Modules\Movie\Models\GenreName;
use Illuminate\Support\Collection;

interface IGenreRepository
{
    public function findByName(GenreName $name): ?Genre;

    public function all(): Collection;
}
