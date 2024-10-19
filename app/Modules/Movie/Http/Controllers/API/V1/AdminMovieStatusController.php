<?php

namespace App\Modules\Movie\Http\Controllers\API\V1;

use App\Contracts\Exceptions\BusinessException;
use App\Contracts\Responses\JsonResponse;
use App\Modules\Movie\Services\MovieStatusService\MovieStatusService;
use Illuminate\Http\Request;

class AdminMovieStatusController
{
    public function __construct(private MovieStatusService $movieStatusService)
    {
    }

    public function publish(Request $request, $imdbID)
    {
        try {
            $this->movieStatusService->publish($imdbID);
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('movie published');
    }

    public function draft(Request $request, $imdbID)
    {
        try {
            $this->movieStatusService->draft($imdbID);
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('movie draft');
    }
}
