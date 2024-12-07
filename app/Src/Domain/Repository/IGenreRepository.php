<?php

namespace App\Src\Domain\Repository;

use App\Src\Domain\Model\Movie\Genre;
use App\Src\Domain\Model\Movie\GenreName;
use Illuminate\Support\Collection;

interface IGenreRepository
{
    public function findByName(GenreName $name): ?Genre;

    public function all(): Collection;

    public function save(Genre $genre): void;
}
