<?php

namespace App\Http\Controllers\API\V1;

use App\Contracts\Exceptions\BusinessException;
use App\Contracts\Responses\JsonResponse;
use App\Http\Controllers\Requests\API\V1\AddToFavoriteRequest;
use App\Http\Controllers\Requests\API\V1\RemoveFavoriteRequest;
use App\Http\Controllers\Requests\API\V1\UserFavoriteMoviesRequest;
use App\Http\Resources\API\V1\MovieResource;
use App\Modules\Favorite\Services\FavoriteService\FavoriteService;
use App\Modules\Movie\Models\IMDBID;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redis;

readonly class UserFavoriteMovieController
{
    public function __construct(private FavoriteService $favoriteService)
    {
    }

    public function addToFavorite(AddToFavoriteRequest $request): Response
    {
        $userID = $request->get('user_id');
        $imdbID = $request->get('imdb_id');
        try {
            $this->favoriteService->add(new IMDBID($imdbID), $userID);

        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('added');
    }

    public function getUserFavoriteMovies(UserFavoriteMoviesRequest $request): Response
    {
        $userID = $request->get('user_id');
        try {
            $movies = $this->favoriteService->userMovies($userID);
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('', MovieResource::collection($movies)->toArray($request));
    }

    public function removeUserFavoriteMovies(RemoveFavoriteRequest $request): Response
    {
        $imdbID = $request->get('imdb_id');
        $userID = $request->get('user_id');
        try {
            $this->favoriteService->remove(new IMDBID($imdbID), $userID);
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('removed');
    }
}
