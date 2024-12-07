<?php

namespace App\Src\Application\CommandHandler\Movie;

use App\Src\Application\Command\Movie\PublishMovieCommand;
use App\Src\Domain\Exceptions\MovieApplicationException;
use App\Src\Domain\Repository\IMovieRepository;

final readonly class PublishMovieCommandHandler
{
    public function __construct(private IMovieRepository $movieRepository)
    {

    }

    /**
     * @throws MovieApplicationException
     */
    public function __invoke(PublishMovieCommand $publishMovieCommand): void
    {
        $movie = $this->movieRepository->findByIMDBID($publishMovieCommand->iMDBID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        $movie->publish();

        $this->movieRepository->save($movie);
    }
}
