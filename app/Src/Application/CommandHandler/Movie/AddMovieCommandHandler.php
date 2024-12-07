<?php

namespace App\Src\Application\CommandHandler\Movie;

use App\Src\Application\Command\Movie\AddMovieCommand;
use App\Src\Application\Service\MovieSearchService\IMovieSearchService;
use App\Src\Domain\Exceptions\MovieApplicationException;
use App\Src\Domain\Model\Movie\Genre;
use App\Src\Domain\Model\Movie\GenreName;
use App\Src\Domain\Model\Movie\IMDBID;
use App\Src\Domain\Model\Movie\Movie;
use App\Src\Domain\Model\Movie\MovieGenre;
use App\Src\Domain\Repository\IGenreRepository;
use App\Src\Domain\Repository\IMovieGenreRepository;
use App\Src\Domain\Repository\IMovieRepository;
use App\Src\Domain\Repository\ITransaction;

final readonly class AddMovieCommandHandler
{
    public function __construct(
        private IMovieRepository      $movieRepository,
        private IMovieGenreRepository $movieGenreRepository,
        private IGenreRepository      $genreRepository,
        private IMovieSearchService   $movieSearchService,
        private ITransaction          $transaction,
    )
    {
    }

    /**
     * @throws MovieApplicationException
     */
    public function __invoke(AddMovieCommand $addMovieCommand): void
    {
        if ($this->movieRepository->exists($addMovieCommand->iMDBID)) {
            throw MovieApplicationException::movieAlreadyExists();
        }

        $searchedMovie = $this->movieSearchService->searchByIMDBID($addMovieCommand->iMDBID);

        $movie = Movie::new(
            $searchedMovie->getTitle(),
            $searchedMovie->getLanguage(),
            $searchedMovie->getCountry(),
            $searchedMovie->getPoster(),
            $searchedMovie->getIMDBID(),
            $searchedMovie->getImdbRating(),
            $searchedMovie->getImdbVotes(),
        );

        $this->transaction->wrap(function () use ($movie, $searchedMovie, $addMovieCommand) {
            $this->movieRepository->save($movie);

            $this->addManyGenres($addMovieCommand->iMDBID, $searchedMovie->getGenres());
        });
    }

    /**
     * @throws MovieApplicationException
     */
    private function addManyGenres(IMDBID $IMDBID, array $genresName): void
    {
        $movie = $this->movieRepository->findByIMDBID($IMDBID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        $this->movieGenreRepository->removeByMovieID($movie->id);

        /** @var GenreName $name */
        foreach ($genresName as $name) {
            $genre = $this->genreRepository->findByName($name);
            if (is_null($genre)) {
                $genre = Genre::new($name);

                $this->genreRepository->save($genre);
            }

            $movieGenre = MovieGenre::new($movie->id, $genre->id);

            $this->movieGenreRepository->save($movieGenre);
        }
    }
}
