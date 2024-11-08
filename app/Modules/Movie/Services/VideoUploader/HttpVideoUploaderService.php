<?php

namespace App\Modules\Movie\Services\VideoUploader;

use App\Contracts\Repositories\IMovieRepository;
use App\Modules\Movie\Exceptions\MovieApplicationException;
use Illuminate\Support\Facades\Storage;

readonly class HttpVideoUploaderService implements IVideoUploader
{
    public function __construct(private IMovieRepository $movieRepository)
    {
    }

    /**
     * @throws MovieApplicationException
     */
    public function upload(string $imdbID, string $videoTempPath, string $extension): void
    {
        $movie = $this->movieRepository->findByIMDBID($imdbID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        if (false === file_exists($videoTempPath)) {
            throw MovieApplicationException::videoTempPathDoesNotExist();
        }

        $directoryPath = storage_path('app/public/movies/%s' . $imdbID);
        $fullPath = sprintf("%s/%s.%s", realpath($directoryPath), $imdbID, $extension);;

        move_uploaded_file($videoTempPath, $fullPath);

        unlink($videoTempPath);

        $movie->url = $fullPath;

        $this->movieRepository->save($movie);
    }
}
