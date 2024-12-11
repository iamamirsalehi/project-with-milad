<?php

namespace App\Domain\Repository;

use App\Domain\Model\Movie\Genre;
use App\Domain\Model\Movie\GenreName;
use Illuminate\Support\Collection;

interface GenreRepository
{
    public function findByName(GenreName $name): ?Genre;

    public function all(): Collection;

    public function save(Genre $genre): void;
}
