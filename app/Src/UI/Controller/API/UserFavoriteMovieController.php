<?php

namespace App\Src\UI\Controller\API;

use App\Src\Application\Command\FavouriteMovie\GetUserFavouriteMovieCommand;
use App\Src\Application\Command\FavouriteMovie\RemoveFavouriteMovieCommand;
use App\Src\Domain\Exceptions\BusinessException;
use App\Src\Domain\Model\Movie\IMDBID;
use App\Src\Domain\Model\User\UserID;
use App\Src\UI\Request\API\AddToFavoriteRequest;
use App\Src\UI\Request\API\RemoveFavoriteRequest;
use App\Src\UI\Request\API\UserFavoriteMoviesRequest;
use App\Src\UI\Resource\API\MovieResource;
use App\Src\UI\Response\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Src\Application\Command\FavouriteMovie\AddFavouriteMovieCommand;

final readonly class UserFavoriteMovieController
{
    public function __construct(
        private MessageBusInterface $messageBus,
    )
    {
    }

    /**
     * @throws ExceptionInterface
     */
    public function addToFavorite(AddToFavoriteRequest $request): Response
    {
        try {
            $userID = new UserID($request->get('user_id'));
            $imdbID = new IMDBID($request->get('imdb_id'));

            $this->messageBus->dispatch(new AddFavouriteMovieCommand($imdbID, $userID));

        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('added');
    }

    /**
     * @throws ExceptionInterface
     */
    public function getUserFavoriteMovies(UserFavoriteMoviesRequest $request): Response
    {
        try {
            $userID = new UserID($request->get('user_id'));

            $movies = $this->messageBus->dispatch(new GetUserFavouriteMovieCommand($userID));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('', MovieResource::collection($movies)->toArray($request));
    }

    /**
     * @throws ExceptionInterface
     */
    public function removeUserFavoriteMovies(RemoveFavoriteRequest $request): Response
    {
        try {
            $imdbID = new IMDBID($request->get('imdb_id'));
            $userID = new UserID($request->get('user_id'));

            $this->messageBus->dispatch(new RemoveFavouriteMovieCommand($imdbID, $userID));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::ok('removed');
    }
}
