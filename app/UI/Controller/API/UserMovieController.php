<?php

namespace App\UI\Controller\API;

use App\Application\Command\WatchMovieCommand;
use App\Application\Query\AllGenreQuery;
use App\Application\Query\FilterMovieQuery;
use App\Application\Query\GetMovieAccessLink;
use App\Application\Query\GetMovieIfAvailableQuery;
use App\Domain\Exceptions\BusinessException;
use App\Domain\Model\Movie\GenreName;
use App\Domain\Model\Movie\IMDBID;
use App\Domain\Model\User\UserID;
use App\Infrastructure\CommandBus\CommandBus;
use App\Infrastructure\QueryBus\QueryBus;
use App\UI\Request\API\GetMovieAccessLinkRequest;
use App\UI\Request\API\MovieRequest;
use App\UI\Request\API\WatchRequest;
use App\UI\Resource\API\GenreResource;
use App\UI\Resource\API\MovieResource;
use App\UI\Response\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

final readonly class UserMovieController
{
    public function __construct(
        private CommandBus $commandBus,
        private QueryBus   $queryBus,
    )
    {
    }

    public function list(Request $request): Response|AnonymousResourceCollection
    {
        $genre = $request->get('genre');
        try {
            $filterMovieCommand = new FilterMovieQuery();

            if (false === is_null($genre)) {
                $filterMovieCommand->setGenreName(new GenreName($genre));
            }

            $movies = $this->queryBus->handle($filterMovieCommand);

        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return MovieResource::collection($movies);
    }

    public function genres(Request $request): AnonymousResourceCollection
    {
        $genres = $this->queryBus->handle(new AllGenreQuery());

        return GenreResource::collection($genres);
    }

    public function get(MovieRequest $request): Response|MovieResource
    {
        try {
            $imdbID = new IMDBID($request->get('imdb_id'));

            $movie = $this->queryBus->handle(new GetMovieIfAvailableQuery($imdbID));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return new MovieResource($movie);
    }

    public function watch(WatchRequest $request): Response
    {
        try {
            $userID = new UserID($request->get('user_id'));
            $imdbID = new IMDBID($request->get('imdb_id'));

            $this->commandBus->handle(new WatchMovieCommand($userID, $imdbID,));

        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('watching');
    }

    public function getAccessLink(GetMovieAccessLinkRequest $request): Response
    {
        try {
            $userID = new UserID($request->get('user_id'));
            $imdbID = new IMDBID($request->get('imdb_id'));

            $accessLink = $this->queryBus->handle(new GetMovieAccessLink($userID, $imdbID));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('', [
            'access-link' => $accessLink
        ]);
    }
}
