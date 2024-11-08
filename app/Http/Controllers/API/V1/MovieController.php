<?php

namespace App\Http\Controllers\API\V1;

use App\Contracts\Exceptions\BusinessException;
use App\Contracts\Responses\JsonResponse;
use App\Http\Controllers\Requests\API\V1\AddToFavoriteRequest;
use App\Http\Controllers\Requests\API\V1\MovieRequest;
use App\Http\Controllers\Requests\API\V1\UserFavoriteMoviesRequest;
use App\Http\Resources\API\V1\MovieResource;
use App\Modules\Favorite\Services\FavoriteService\FavoriteService;
use App\Modules\Movie\Models\IMDBID;
use App\Modules\Movie\Services\MovieService\MovieService;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

readonly class MovieController
{
    public function __construct(
        private MovieService    $movieService,
    )
    {
    }

    public function get(MovieRequest $request): Response
    {
        $imdbID = $request->get('imdb_id');
        try {
            $movie = $this->movieService->getIfAvailable($imdbID);
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('', [
            'title' => $movie->title,
            'language' => $movie->language,
            'country' => $movie->country,
            'poster' => $movie->poster,
            'url' => $movie->url,
            'imdbRating' => $movie->imdb_rating,
            'imdbID' => $movie->imdb_id,
            'imdbVotes' => $movie->imdb_votes,
        ]);
    }
}
