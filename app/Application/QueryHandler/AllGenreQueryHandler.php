<?php

namespace App\Application\QueryHandler;

use App\Application\Query\AllGenreQuery;
use App\Domain\Repository\GenreRepository;
use Illuminate\Support\Collection;

final readonly class AllGenreQueryHandler
{
    public function __construct(private GenreRepository $genreRepository)
    {
    }

    public function __invoke(AllGenreQuery $allGenreCommand): Collection
    {
        return $this->genreRepository->all();
    }
}
