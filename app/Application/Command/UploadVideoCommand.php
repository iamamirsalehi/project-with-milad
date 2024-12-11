<?php

namespace App\Application\Command;

use App\Domain\Model\Movie\IMDBID;

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
