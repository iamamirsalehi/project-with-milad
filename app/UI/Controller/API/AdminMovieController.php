<?php

namespace App\UI\Controller\API;

use App\Application\Command\AddMovieCommand;
use App\Application\Command\DraftMovieCommand;
use App\Application\Command\PublishMovieCommand;
use App\Application\Command\UploadVideoCommand;
use App\Application\Query\GetMovieQuery;
use App\Domain\Exceptions\BusinessException;
use App\Domain\Model\Movie\IMDBID;
use App\Infrastructure\CommandBus\CommandBus;
use App\Infrastructure\QueryBus\QueryBus;
use App\UI\Request\API\MovieRequest;
use App\UI\Request\API\UploadMovieRequest;
use App\UI\Resource\API\MovieResource;
use App\UI\Response\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final readonly class AdminMovieController
{
    public function __construct(
        private QueryBus   $queryBus,
        private CommandBus $commandBus,
    )
    {
    }

    public function get(MovieRequest $request): Response
    {
        try {
            $imdbID = new IMDBID($request->get('imdb_id'));

            $movie = $this->queryBus->handle(new GetMovieQuery($imdbID));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('', (new MovieResource($movie))->toArray($request));
    }

    public function add(MovieRequest $request): Response
    {
        try {
            $imdbID = new IMDBID($request->get('imdb_id'));

            $this->commandBus->handle(new AddMovieCommand($imdbID));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::created('added');
    }

    public function uploadVideo(UploadMovieRequest $request, $imdbID): Response
    {
        try {
            $imdbID = new IMDBID($imdbID);
            $tempPath = $request->file('video')->path();
            $extension = $request->file('video')->getClientOriginalExtension();

            $this->queryBus->handle(new UploadVideoCommand($imdbID, $tempPath, $extension));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('movie uploaded successfully');
    }

    public function publish(Request $request, $imdbID): Response
    {
        try {
            $this->commandBus->handle(new PublishMovieCommand(new IMDBID($imdbID)));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('movie published');
    }

    public function draft(Request $request, $imdbID): Response
    {
        try {
            $this->commandBus->handle(new DraftMovieCommand(new IMDBID($imdbID)));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('movie draft');
    }
}
