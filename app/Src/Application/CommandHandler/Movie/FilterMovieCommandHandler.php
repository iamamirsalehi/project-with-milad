<?php

namespace App\Src\Application\CommandHandler\Movie;

use App\Src\Application\Command\Movie\FilterMovieCommand;
use App\Src\Domain\Enums\MovieStatus;
use App\Src\Domain\Exceptions\MovieApplicationException;
use App\Src\Domain\Repository\IGenreRepository;
use App\Src\Domain\Repository\IMovieRepository;
use Illuminate\Support\Collection;

final readonly class FilterMovieCommandHandler
{
    public function __construct(
        private IGenreRepository $genreRepository,
        private IMovieRepository $movieRepository,
    )
    {

    }

    /**
     * @throws MovieApplicationException
     */
    public function __invoke(FilterMovieCommand $allMovieCommand): Collection
    {
        if (false === is_null($allMovieCommand->getGenreName())) {
            $genre = $this->genreRepository->findByName($allMovieCommand->getGenreName());
            if (is_null($genre)) {
                throw MovieApplicationException::invalidMovieGenreName();
            }

            return $this->movieRepository->filter(MovieStatus::Published, $genre);
        }

        return $this->movieRepository->filter(MovieStatus::Published);
    }
}
