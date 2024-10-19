<?php

namespace App\Modules\Movie\Services\VideoUploader;

use App\Models\Movie;
use App\Modules\Movie\Exceptions\MovieApplicationException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class VideoUploaderService implements VideoUploaderServiceInterface
{
    public function upload(UploadedFile $file, string $imdbID): void
    {
        $movie = Movie::findByIMDBID($imdbID);
        if (!$movie) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        $path = sprintf("movies/%s", $movie->imdb_id);

        $uploadedPath = $file->storePublicly($path);
        if (!$uploadedPath) {
            throw MovieApplicationException::couldNotUploadVideo();
        }

        $movie->url = Storage::url($uploadedPath);
        $movie->save();
    }
}
