<?php

namespace App\Modules\Movie\Services\VideoUploader;

use Illuminate\Http\UploadedFile;

interface VideoUploaderServiceInterface
{
    public function upload(UploadedFile $file, string $imdbID): void;
}
