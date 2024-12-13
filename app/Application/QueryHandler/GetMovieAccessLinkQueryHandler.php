<?php

namespace App\Application\QueryHandler;

use App\Application\Query\GetMovieAccessLink;
use App\Application\Service\MovieAccessService\MovieAccessService;
use App\Domain\Exceptions\MovieApplicationException;
use App\Domain\Model\Movie\MovieURL;
use App\Domain\Repository\MovieRepository;

final readonly class GetMovieAccessLinkQueryHandler
{
    public function __construct(
        private MovieAccessService $movieAccessService,
        private MovieRepository    $movieRepository,
    )
    {

    }

    /**
     * @throws MovieApplicationException
     */
    public function __invoke(GetMovieAccessLink $getMovieAccessLink): MovieURL
    {
        $movie = $this->movieRepository->findByIMDBID($getMovieAccessLink->imdbID);
        if (is_null($movie)) {
            throw MovieApplicationException::invalidMovieID();
        }

        if (!$movie->isAvailable()) {
            throw MovieApplicationException::movieIsNotAvailable();
        }

        $hasAccessToMovie = $this->movieAccessService->hasAccessToMovie($getMovieAccessLink->userID, $getMovieAccessLink->imdbID);
        if (!$hasAccessToMovie) {
            throw MovieApplicationException::movieIsNotAccessible();
        }

        return $movie->url;
    }
}
