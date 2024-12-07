<?php

namespace App\Src\Application\Command\MovieRent;

use App\Src\Domain\Model\Movie\MovieID;
use App\Src\Domain\Model\User\UserID;

final readonly class ActivateMovieRentCommand
{
    public function __construct(
        public MovieID $movieID,
        public UserID  $userID,
    )
    {
    }
}
