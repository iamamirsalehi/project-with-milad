<?php

namespace App\Modules\Movie\Services\VideoUploader;

use App\Contracts\Repositories\IMovieRepository;
use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Movie\Models\IMDBID;

final readonly class VideoUploaderService
{
    public function __construct(
        private IMovieRepository $movieRepository,
        private IVideoUploader   $videoUploader,
    )
    {
    }

    /**
     * @throws MovieApplicationException
     */
    public function upload(IMDBID $imdbID, string $videoTempPath, string $extension): void
    {
        $movie = $this->movieRepository->findByIMDBID($imdbID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        $url = $this->videoUploader->upload($imdbID, $videoTempPath, $extension);

        $movie->url = $url;

        $this->movieRepository->save($movie);
    }
}
