<?php

namespace App\UI\Controller\API;

use App\Application\Command\AddFavouriteMovieCommand;
use App\Application\Command\RemoveFavouriteMovieCommand;
use App\Application\Query\GetUserFavouriteMovieQuery;
use App\Domain\Exceptions\BusinessException;
use App\Domain\Model\Movie\IMDBID;
use App\Domain\Model\User\UserID;
use App\Infrastructure\CommandBus\CommandBus;
use App\Infrastructure\QueryBus\QueryBus;
use App\UI\Request\API\AddToFavoriteRequest;
use App\UI\Request\API\RemoveFavoriteRequest;
use App\UI\Request\API\UserFavoriteMoviesRequest;
use App\UI\Resource\API\MovieResource;
use App\UI\Response\JsonResponse;
use Illuminate\Http\Response;

final readonly class UserFavoriteMovieController
{
    public function __construct(
        private CommandBus $commandBus,
        private QueryBus   $queryBus,
    )
    {
    }

    public function addToFavorite(AddToFavoriteRequest $request): Response
    {
        try {
            $userID = new UserID($request->get('user_id'));
            $imdbID = new IMDBID($request->get('imdb_id'));

            $this->commandBus->handle(new AddFavouriteMovieCommand($imdbID, $userID));

        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('added');
    }

    public function getUserFavoriteMovies(UserFavoriteMoviesRequest $request): Response
    {
        try {
            $userID = new UserID($request->get('user_id'));

            $movies = $this->queryBus->handle(new GetUserFavouriteMovieQuery($userID));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('', MovieResource::collection($movies)->toArray($request));
    }

    public function removeUserFavoriteMovies(RemoveFavoriteRequest $request): Response
    {
        try {
            $imdbID = new IMDBID($request->get('imdb_id'));
            $userID = new UserID($request->get('user_id'));

            $this->commandBus->handle(new RemoveFavouriteMovieCommand($imdbID, $userID));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('removed');
    }
}
