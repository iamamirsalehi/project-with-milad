<?php

namespace App\Modules\Movie\Services\MovieGenreService;

use App\Contracts\Repositories\IGenreRepository;
use App\Contracts\Repositories\IMovieGenreRepository;
use App\Contracts\Repositories\IMovieRepository;
use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Movie\Models\GenreName;
use App\Modules\Movie\Models\IMDBID;
use App\Modules\Movie\Models\MovieGenre;
use Illuminate\Support\Collection;

readonly class MovieGenreService
{
    public function __construct(
        private IMovieRepository      $movieRepository,
        private IGenreRepository      $genreRepository,
        private IMovieGenreRepository $movieGenreRepository,
    )
    {
    }

    public function all(): Collection
    {
        return $this->genreRepository->all();
    }

    /**
     * @throws MovieApplicationException
     */
    public function addMany(IMDBID $IMDBID, array $genresName): void
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
                throw MovieApplicationException::invalidMovieGenreName();
            }

            $movieGenre = MovieGenre::new($movie->id, $genre->id);

            $this->movieGenreRepository->save($movieGenre);
        }
    }
}
