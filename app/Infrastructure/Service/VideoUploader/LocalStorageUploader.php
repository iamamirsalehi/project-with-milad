<?php

namespace App\Infrastructure\Service\VideoUploader;

use App\Domain\Model\Movie\IMDBID;
use App\Domain\Service\VideoUploader\VideoUploader;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

final class LocalStorageUploader implements VideoUploader
{
    public function upload(IMDBID $imdbID, string $videoTempPath, string $extension): string
    {
        $tempFile = new File($videoTempPath);
        $destinationPath = sprintf('movies/%s/', $imdbID->toPrimitiveType());
        $fileName = sprintf("movies-%s-video.%s", Carbon::now()->timestamp, $tempFile->extension());

        Storage::disk('public')->putFileAs($destinationPath, $tempFile, $fileName);

        return Storage::disk('public')->url(sprintf('%s%s', $destinationPath, $fileName));
    }
}
