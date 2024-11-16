<?php

namespace App\Modules\Movie\Services\MovieService;

use App\Modules\Movie\Enums\MovieRentType;
use App\Modules\Movie\Models\IMDBID;
use App\Modules\User\Models\UserID;

readonly class MovieRentData
{
    public function __construct(
        private IMDBID        $IMDBID,
        private MovieRentType $rentType,
        private UserID        $userID,
    )
    {
    }

    public function getIMDBID(): IMDBID
    {
        return $this->IMDBID;
    }

    public function getRentType(): MovieRentType
    {
        return $this->rentType;
    }

    public function getUserID(): UserID
    {
        return $this->userID;
    }
}
