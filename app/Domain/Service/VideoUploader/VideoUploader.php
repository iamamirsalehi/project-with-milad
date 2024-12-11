<?php

namespace App\Domain\Service\VideoUploader;

use App\Domain\Model\Movie\IMDBID;

interface VideoUploader
{
    public function upload(IMDBID $imdbID, string $videoTempPath, string $extension): string;
}
