<?php

namespace App\Services\MovieSearch;

use App\Models\Movie;

interface MovieSearchInterface
{
    public function search(MovieSearchDto $dto): ?Movie;
}
