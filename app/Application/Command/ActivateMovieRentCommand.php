<?php

namespace App\Application\Command;

use App\Domain\Model\Movie\MovieID;
use App\Domain\Model\User\UserID;

final readonly class ActivateMovieRentCommand
{
    public function __construct(
        public MovieID $movieID,
        public UserID  $userID,
    )
    {
    }
}
