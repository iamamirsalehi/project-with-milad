<?php

namespace App\Src\Instrastructure\Service\VideoUploader;

use App\Src\Domain\Model\Movie\IMDBID;
use App\Src\Domain\Service\VideoUploader\IVideoUploader;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

final class LocalStorageUploader implements IVideoUploader
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
