<?php

namespace App\Application\Query;

use App\Domain\Model\User\UserID;

final readonly class GetUserFavouriteMovieQuery
{
    public function __construct(public UserID $userID)
    {
    }
}
