<?php

namespace App\Modules\Movie\Services\MovieStatusService;

use App\Contracts\Repositories\Eloquent\Movie\MovieResult;
use App\Contracts\Repositories\IMovieRepository;
use App\Modules\Movie\Enums\MovieStatus;
use App\Modules\Movie\Exceptions\MovieApplicationException;

readonly class MovieStatusService
{
    public function __construct(private IMovieRepository $movieRepository)
    {
    }

    /**
     * @throws MovieApplicationException
     */
    public function publish(string $imdbID): void
    {
        /** @var MovieResult $movie */
        $movie = $this->movieRepository->findByIMDBID($imdbID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        if ($movie->getStatus() == MovieStatus::Published) {
            throw MovieApplicationException::movieIsAlreadyPublished();
        }

        if (is_null($movie->getUrl())) {
            throw MovieApplicationException::movieDoesNotHaveVideo();
        }

        $this->movieRepository->changeStatusToPublished($imdbID);
    }

    /**
     * @throws MovieApplicationException
     */
    public function draft(string $imdbID): void
    {
        /** @var MovieResult $movie */
        $movie = $this->movieRepository->findByIMDBID($imdbID);
        if (is_null($movie)) {
            throw MovieApplicationException::couldNotFindMovie();
        }

        if ($movie->getStatus() == MovieStatus::Draft) {
            throw MovieApplicationException::movieIsAlreadyDraft();
        }

        $this->movieRepository->changeStatusToDraft($imdbID);
    }
}
