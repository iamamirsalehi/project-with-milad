<?php

declare(strict_types=1);

namespace App\Application\Service\MovieRentService;

use App\Domain\Model\Movie\Duration;
use App\Domain\Model\Movie\MovieID;
use App\Domain\Model\User\UserID;

final readonly class NewMovieRent
{
    public function __construct(
        private MovieID  $movieID,
        private UserID   $userID,
        private Duration $duration,
    )
    {
    }

    public function getMovieID(): MovieID
    {
        return $this->movieID;
    }

    public function getUserID(): UserID
    {
        return $this->userID;
    }

    public function getDuration(): Duration
    {
        return $this->duration;
    }
}
