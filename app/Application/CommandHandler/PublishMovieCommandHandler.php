<?php

namespace App\Application\CommandHandler;

use App\Application\Command\PublishMovieCommand;
use App\Domain\Exceptions\MovieApplicationException;
use App\Domain\Repository\MovieRepository;

final readonly class PublishMovieCommandHandler
{
    public function __construct(private MovieRepository $movieRepository)
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
