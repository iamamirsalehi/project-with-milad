<?php

namespace App\Modules\Movie\Services\MovieService;

use App\Modules\Movie\Models\Duration;
use App\Modules\Movie\Models\MovieID;
use App\Modules\User\Models\UserID;

readonly class NewMovieRent
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
