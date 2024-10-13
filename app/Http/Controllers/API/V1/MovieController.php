<?php

namespace App\Http\Controllers\API\V1;

use App\Contracts\Exceptions\BusinessException;
use App\Contracts\Responses\JsonResponse;
use App\Http\Requests\API\V1\GetMovieRequest;
use App\Http\Requests\API\V1\UploadMovieRequest;
use App\Services\MovieSearch\MovieSearchDto;
use App\Services\MovieSearch\MovieSearchInterface;
use App\Services\VideoUploader\VideoUploaderServiceInterface;

class MovieController
{
    public function __construct(
        private MovieSearchInterface          $movieSearchService,
        private VideoUploaderServiceInterface $videoUploaderService,
    )
    {
    }

    public function get(GetMovieRequest $request)
    {
        $dto = new MovieSearchDto();
        if ($request->has('title')) {
            $dto->setTitle($request->get('title'));
        }

        if ($request->has('imdb_id')) {
            $dto->setImdbID($request->get('imdb_id'));
        }

        try {
            $movie = $this->movieSearchService->search($dto);
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('', $movie?->toArray());
    }

    public function uploadVideo(UploadMovieRequest $request, $imdbID)
    {
        try {
            $this->videoUploaderService->upload($request->file('video'), $imdbID);
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('movie uploaded successfully');
    }
}
