<?php

namespace App\Src\UI\Controller\API;

use App\Src\Application\Command\Movie\AddMovieCommand;
use App\Src\Application\Command\Movie\DraftMovieCommand;
use App\Src\Application\Command\Movie\GetMovieCommand;
use App\Src\Application\Command\Movie\PublishMovieCommand;
use App\Src\Application\Command\Movie\UploadVideoCommand;
use App\Src\Domain\Exceptions\BusinessException;
use App\Src\Domain\Model\Movie\IMDBID;
use App\Src\UI\Request\API\MovieRequest;
use App\Src\UI\Request\API\UploadMovieRequest;
use App\Src\UI\Resource\API\MovieResource;
use App\Src\UI\Response\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class AdminMovieController
{
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    /**
     * @throws ExceptionInterface
     */
    public function get(MovieRequest $request): Response
    {
        try {
            $imdbID = new IMDBID($request->get('imdb_id'));

            $movie = $this->messageBus->dispatch(new GetMovieCommand($imdbID));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('', (new MovieResource($movie))->toArray($request));
    }

    /**
     * @throws ExceptionInterface
     */
    public function add(MovieRequest $request): Response
    {
        try {
            $imdbID = new IMDBID($request->get('imdb_id'));

            $this->messageBus->dispatch(new AddMovieCommand($imdbID));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::created('added');
    }

    /**
     * @throws ExceptionInterface
     */
    public function uploadVideo(UploadMovieRequest $request, $imdbID): Response
    {
        try {
            $imdbID = new IMDBID($imdbID);
            $tempPath = $request->file('video')->path();
            $extension = $request->file('video')->getClientOriginalExtension();

            $this->messageBus->dispatch(new UploadVideoCommand($imdbID, $tempPath, $extension));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('movie uploaded successfully');
    }

    /**
     * @throws ExceptionInterface
     */
    public function publish(Request $request, $imdbID): Response
    {
        try {
            $this->messageBus->dispatch(new PublishMovieCommand(new IMDBID($imdbID)));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('movie published');
    }

    /**
     * @throws ExceptionInterface
     */
    public function draft(Request $request, $imdbID): Response
    {
        try {
            $this->messageBus->dispatch(new DraftMovieCommand(new IMDBID($imdbID)));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('movie draft');
    }
}
