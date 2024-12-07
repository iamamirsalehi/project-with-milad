<?php

namespace App\Src\Application\CommandHandler\Genre;

use App\Src\Application\Command\Genre\AllGenreCommand;
use App\Src\Domain\Repository\IGenreRepository;
use Illuminate\Support\Collection;

final readonly class AllGenreCommandHandler
{
    public function __construct(private IGenreRepository $genreRepository)
    {
    }

    public function __invoke(AllGenreCommand $allGenreCommand): Collection
    {
        return $this->genreRepository->all();
    }
}
