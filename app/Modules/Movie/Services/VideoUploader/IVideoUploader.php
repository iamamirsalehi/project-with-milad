<?php

namespace App\Modules\Movie\Services\VideoUploader;

interface IVideoUploader
{
    public function upload(string $imdbID, string $videoTempPath, string $extension): void;
}
