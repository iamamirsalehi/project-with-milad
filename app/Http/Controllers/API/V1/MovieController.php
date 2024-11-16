<?php

namespace App\Http\Controllers\API\V1;

use App\Contracts\Exceptions\BusinessException;
use App\Contracts\Responses\JsonResponse;
use App\Http\Controllers\Requests\API\V1\MovieRequest;
use App\Http\Controllers\Requests\API\V1\RentRequest;
use App\Modules\Movie\Models\IMDBID;
use App\Modules\Movie\Services\MovieService\MovieService;
use Illuminate\Http\Response;

readonly class MovieController
{
    public function __construct(
        private MovieService $movieService,
    )
    {
    }

    public function get(MovieRequest $request): Response
    {
        $imdbID = $request->get('imdb_id');
        try {
            $movie = $this->movieService->getIfAvailable(new IMDBID($imdbID));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('', [
            'title' => $movie->title,
            'language' => $movie->language->toPrimitiveType(),
            'country' => $movie->country->toPrimitiveType(),
            'poster' => $movie->poster->toPrimitiveType(),
            'url' => $movie->url,
            'imdbRating' => $movie->imdb_rating->toPrimitiveType(),
            'imdbID' => $movie->imdb_id->toPrimitiveType(),
            'imdbVotes' => $movie->imdb_votes->toPrimitiveType(),
        ]);
    }

    public function rent(RentRequest $request): Response
    {
        $imdbID = $request->get('imdb_id');
        $userID = $request->get('user_id');

        try {
//            $this->movieService->ren
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('');
    }
}
