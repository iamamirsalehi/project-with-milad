<?php

namespace App\Application\CommandHandler;

use App\Application\Command\UploadVideoCommand;
use App\Domain\Exceptions\MovieApplicationException;
use App\Domain\Repository\MovieRepository;
use App\Domain\Service\VideoUploader\VideoUploader;

final readonly class UploadVideoCommandHandler
{
    public function __construct(
        private MovieRepository $movieRepository,
        private VideoUploader $videoUploader
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
