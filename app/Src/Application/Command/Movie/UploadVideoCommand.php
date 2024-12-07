<?php

namespace App\Src\Application\Command\Movie;

use App\Src\Domain\Model\Movie\IMDBID;

final readonly class UploadVideoCommand
{
    public function __construct(
        public IMDBID $imdbID,
        public string $videoTempPath,
        public string $extension,
    )
    {

    }
}
