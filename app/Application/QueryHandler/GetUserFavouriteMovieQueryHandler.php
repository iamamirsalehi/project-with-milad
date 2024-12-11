<?php

namespace App\Application\QueryHandler;

use App\Application\Query\GetUserFavouriteMovieQuery;
use App\Domain\Exceptions\MovieApplicationException;
use App\Domain\Repository\FavoriteRepository;
use Illuminate\Support\Collection;

final readonly class GetUserFavouriteMovieQueryHandler
{
    public function __construct(private FavoriteRepository $favoriteRepository)
    {

    }

    /**
     * @throws MovieApplicationException
     */
    public function __invoke(GetUserFavouriteMovieQuery $getUserFavouriteMovieCommand): Collection
    {
        $userFavoriteList = $this->favoriteRepository->getAllByUserID($getUserFavouriteMovieCommand->userID);
        if ($userFavoriteList->isEmpty()) {
            throw MovieApplicationException::userDoesNotHaveAnyFavoritesMovie();
        }

        return $userFavoriteList;
    }
}
