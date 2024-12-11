<?php

namespace App\Application\CommandHandler;

use App\Application\Command\AddMovieCommand;
use App\Application\Service\MovieSearchService\IMovieSearchService;
use App\Domain\Exceptions\MovieApplicationException;
use App\Domain\Model\Movie\Genre;
use App\Domain\Model\Movie\GenreName;
use App\Domain\Model\Movie\IMDBID;
use App\Domain\Model\Movie\Movie;
use App\Domain\Model\Movie\MovieGenre;
use App\Domain\Repository\GenreRepository;
use App\Domain\Repository\MovieGenreRepository;
use App\Domain\Repository\MovieRepository;
use App\Domain\Repository\Transaction;

final readonly class AddMovieCommandHandler
{
    public function __construct(
        private MovieRepository      $movieRepository,
        private MovieGenreRepository $movieGenreRepository,
        private GenreRepository      $genreRepository,
        private IMovieSearchService  $movieSearchService,
        private Transaction          $transaction,
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
