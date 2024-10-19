<?php

namespace App\Modules\Movie\Services\VideoUploader;

use App\Contracts\Repositories\Eloquent\Movie\MovieResult;
use App\Contracts\Repositories\IMovieRepository;
use App\Modules\Movie\Exceptions\MovieApplicationException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class VideoUploaderService
{
    public function __construct(private IMovieRepository $movieRepository)
    {
    }

    /**
     * @throws MovieApplicationException
     */
    public function upload(UploadedFile $file, string $imdbID): void
    {
        /** @var MovieResult $movie */
        $movie = $this->movieRepository->findByIMDBID($imdbID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        $path = sprintf("movies/%s", $movie->getImdbID());

        $uploadedPath = $file->storePublicly($path);
        if (!$uploadedPath) {
            throw MovieApplicationException::couldNotUploadVideo();
        }

        $this->movieRepository->updateURL($movie->getImdbID(),  Storage::url($uploadedPath));
    }
}
