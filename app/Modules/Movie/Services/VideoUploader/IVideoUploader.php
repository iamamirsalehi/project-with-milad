<?php

namespace App\Modules\Movie\Services\VideoUploader;

use App\Modules\Movie\Models\IMDBID;

interface IVideoUploader
{
    public function upload(IMDBID $imdbID, string $videoTempPath, string $extension): void;
}
