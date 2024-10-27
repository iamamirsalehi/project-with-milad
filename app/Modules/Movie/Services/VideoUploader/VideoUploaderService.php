<?php

namespace App\Modules\Movie\Services\VideoUploader;

use App\Contracts\Repositories\IMovieRepository;
use App\Modules\Movie\Exceptions\MovieApplicationException;

class VideoUploaderService
{
    public function __construct(private IMovieRepository $movieRepository)
    {
    }

    /**
     * @throws MovieApplicationException
     */
    public function upload(string $imdbID, string $fullVideoPath): void
    {
        $movie = $this->movieRepository->findByIMDBID($imdbID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        $movie->url = $fullVideoPath;

        $this->movieRepository->save($movie);
    }
}
