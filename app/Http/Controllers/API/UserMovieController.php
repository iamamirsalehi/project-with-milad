<?php

namespace App\Http\Controllers\API;

use App\Contracts\Exceptions\BusinessException;
use App\Contracts\Repositories\IGenreRepository;
use App\Contracts\Responses\JsonResponse;
use App\Http\Controllers\Requests\API\MovieRequest;
use App\Http\Controllers\Requests\API\WatchRequest;
use App\Http\Resources\API\GenreResource;
use App\Http\Resources\API\MovieResource;
use App\Modules\Movie\Models\GenreName;
use App\Modules\Movie\Models\IMDBID;
use App\Modules\Movie\Services\MovieService\AllMovieFilter;
use App\Modules\Movie\Services\MovieService\MovieService;
use App\Modules\User\Models\UserID;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

final readonly class UserMovieController
{
    public function __construct(
        private MovieService     $movieService,
        private IGenreRepository $genreRepository,
    )
    {
    }

    public function list(Request $request): Response|AnonymousResourceCollection
    {
        $genre = $request->get('genre');
        $allMovieFilter = new AllMovieFilter();
        try {
            if (false === is_null($genre)) {
                $allMovieFilter->setGenreName(new GenreName($genre));
            }

            $movies = $this->movieService->all($allMovieFilter);

        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return MovieResource::collection($movies);
    }

    public function genres(Request $request): AnonymousResourceCollection
    {
        $genres = $this->genreRepository->all();

        return GenreResource::collection($genres);
    }

    public function get(MovieRequest $request): Response|MovieResource
    {
        $imdbID = $request->get('imdb_id');
        try {
            $movie = $this->movieService->getIfAvailable(new IMDBID($imdbID));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return new MovieResource($movie);
    }

    public function watch(WatchRequest $request): Response
    {
        $imdbID = $request->get('imdb_id');
        $userID = $request->get('user_id');
        try {
            $this->movieService->watch(new IMDBID($imdbID), new UserID($userID));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('watching');
    }
}
