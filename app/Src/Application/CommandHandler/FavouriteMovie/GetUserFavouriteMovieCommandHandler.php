<?php

namespace App\Src\Application\CommandHandler\FavouriteMovie;

use App\Src\Application\Command\FavouriteMovie\GetUserFavouriteMovieCommand;
use App\Src\Domain\Exceptions\MovieApplicationException;
use App\Src\Domain\Repository\IFavoriteRepository;
use Illuminate\Support\Collection;

final readonly class GetUserFavouriteMovieCommandHandler
{
    public function __construct(private IFavoriteRepository $favoriteRepository)
    {

    }

    /**
     * @throws MovieApplicationException
     */
    public function __invoke(GetUserFavouriteMovieCommand $getUserFavouriteMovieCommand): Collection
    {
        $userFavoriteList = $this->favoriteRepository->getAllByUserID($getUserFavouriteMovieCommand->userID);
        if ($userFavoriteList->isEmpty()) {
            throw MovieApplicationException::userDoesNotHaveAnyFavoritesMovie();
        }

        return $userFavoriteList;
    }
}
