<?php

namespace App\Modules\Movie\Http\Controllers\API\V1;

use App\Contracts\Exceptions\BusinessException;
use App\Contracts\Responses\JsonResponse;
use App\Modules\Movie\Http\Requests\API\V1\GetMovieRequest;
use App\Modules\Movie\Services\MovieService\MovieService;

class MovieController
{
    public function __construct(
        private MovieService $movieService,
    )
    {
    }

    public function get(GetMovieRequest $request)
    {
        $imdbID = $request->get('imdb_id');
        try {
            $movie = $this->movieService->getIfAvailable($imdbID);
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('', [
            'title' => $movie->getTitle(),
            'language' => $movie->getLanguage(),
            'country' => $movie->getCountry(),
            'poster' => $movie->getPoster(),
            'url' => $movie->getUrl(),
            'imdbRating' => $movie->getImdbRating(),
            'imdbID' => $movie->getImdbID(),
            'imdbVotes' => $movie->getImdbVotes(),
        ]);
    }
}
