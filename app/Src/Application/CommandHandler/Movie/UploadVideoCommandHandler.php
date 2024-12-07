<?php

namespace App\Src\Application\CommandHandler\Movie;

use App\Src\Application\Command\Movie\UploadVideoCommand;
use App\Src\Domain\Exceptions\MovieApplicationException;
use App\Src\Domain\Repository\IMovieRepository;
use App\Src\Domain\Service\VideoUploader\IVideoUploader;

final readonly class UploadVideoCommandHandler
{
    public function __construct(
        private IMovieRepository $movieRepository,
        private IVideoUploader   $videoUploader
    )
    {

    }

    /**
     * @throws MovieApplicationException
     */
    public function __invoke(UploadVideoCommand $uploadVideoCommand): void
    {
        $movie = $this->movieRepository->findByIMDBID($uploadVideoCommand->imdbID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        $url = $this->videoUploader->upload($uploadVideoCommand->imdbID, $uploadVideoCommand->videoTempPath, $uploadVideoCommand->extension);

        $movie->url = $url;

        $this->movieRepository->save($movie);
    }
}
