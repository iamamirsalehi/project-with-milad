<?php

namespace App\Src\Domain\Service\VideoUploader;

use App\Src\Domain\Model\Movie\IMDBID;

interface IVideoUploader
{
    public function upload(IMDBID $imdbID, string $videoTempPath, string $extension): string;
}
