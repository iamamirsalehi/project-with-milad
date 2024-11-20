<?php

namespace App\Http\Controllers\API\V1;

use App\Contracts\Exceptions\BusinessException;
use App\Contracts\Responses\JsonResponse;
use App\Http\Controllers\Requests\API\V1\MovieRequest;
use App\Http\Controllers\Requests\API\V1\UploadMovieRequest;
use App\Http\Resources\API\V1\MovieResource;
use App\Modules\Movie\Models\IMDBID;
use App\Modules\Movie\Services\MovieService\MovieService;
use App\Modules\Movie\Services\VideoUploader\VideoUploaderService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

readonly class AdminMovieController
{
    public function __construct(
        private MovieService         $movieService,
        private VideoUploaderService $videoUploaderService,
    )
    {
    }

    public function get(MovieRequest $request): Response|MovieResource
    {
        $imdbID = $request->get('imdb_id');
        try {
            $movie = $this->movieService->get(new IMDBID($imdbID));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return new MovieResource($movie);
    }

    public function add(MovieRequest $request): Response
    {
        $imdbID = $request->get('imdb_id');
        try {
            $this->movieService->add(new IMDBID($imdbID));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::created('added');
    }

    public function uploadVideo(UploadMovieRequest $request, $imdbID): Response
    {
        try {
            $this->videoUploaderService->upload(
                new IMDBID($imdbID),
                $request->file('video')->path(),
                $request->file('video')->getClientOriginalExtension()
            );
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('movie uploaded successfully');
    }

    public function publish(Request $request, $imdbID): Response
    {
        try {
            $this->movieService->publish(new IMDBID($imdbID));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('movie published');
    }

    public function draft(Request $request, $imdbID): Response
    {
        try {
            $this->movieService->draft(new IMDBID($imdbID));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('movie draft');
    }
}
