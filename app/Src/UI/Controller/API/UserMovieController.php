<?php

namespace App\Src\UI\Controller\API;

use App\Src\Application\Command\Genre\AllGenreCommand;
use App\Src\Application\Command\Movie\FilterMovieCommand;
use App\Src\Application\Command\Movie\GetMovieIfAvailableCommand;
use App\Src\Application\Command\Movie\WatchMovieCommand;
use App\Src\Domain\Exceptions\BusinessException;
use App\Src\Domain\Model\Movie\GenreName;
use App\Src\Domain\Model\Movie\IMDBID;
use App\Src\Domain\Model\User\UserID;
use App\Src\UI\Request\API\MovieRequest;
use App\Src\UI\Request\API\WatchRequest;
use App\Src\UI\Resource\API\GenreResource;
use App\Src\UI\Resource\API\MovieResource;
use App\Src\UI\Response\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class UserMovieController
{
    public function __construct(
        private MessageBusInterface $messageBus,
    )
    {
    }

    /**
     * @throws ExceptionInterface
     */
    public function list(Request $request): Response|AnonymousResourceCollection
    {
        $genre = $request->get('genre');
        try {
            $filterMovieCommand = new FilterMovieCommand();

            if (false === is_null($genre)) {
                $filterMovieCommand->setGenreName(new GenreName($genre));
            }

            $movies = $this->messageBus->dispatch($filterMovieCommand);

        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return MovieResource::collection($movies);
    }

    /**
     * @throws ExceptionInterface
     */
    public function genres(Request $request): AnonymousResourceCollection
    {
        $genres = $this->messageBus->dispatch(new AllGenreCommand());

        return GenreResource::collection($genres);
    }

    /**
     * @throws ExceptionInterface
     */
    public function get(MovieRequest $request): Response|MovieResource
    {
        try {
            $imdbID = new IMDBID($request->get('imdb_id'));

            $movie = $this->messageBus->dispatch(new GetMovieIfAvailableCommand($imdbID));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return new MovieResource($movie);
    }

    /**
     * @throws ExceptionInterface
     */
    public function watch(WatchRequest $request): Response
    {
        try {
            $userID = new UserID($request->get('user_id'));
            $imdbID = new IMDBID($request->get('imdb_id'));

            $this->messageBus->dispatch(new WatchMovieCommand($userID, $imdbID,));

        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('watching');
    }
}
