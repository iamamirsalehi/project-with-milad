<?php

namespace App\Modules\Movie\Services\MovieService;

use App\Modules\Movie\Models\Duration;
use App\Modules\Movie\Models\IMDBID;
use App\Modules\User\Models\UserID;

readonly class NewMovieRent
{
    public function __construct(
        private IMDBID   $IMDBID,
        private UserID   $userID,
        private Duration $duration,
    )
    {
    }

    public function getIMDBID(): IMDBID
    {
        return $this->IMDBID;
    }

    public function getDuration(): Duration
    {
        return $this->duration;
    }

    public function getUserID(): UserID
    {
        return $this->userID;
    }
}
