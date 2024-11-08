<?php

namespace App\Modules\Movie\Services\MovieService;

use App\Modules\Movie\Enums\MovieRentType;
use App\Modules\Movie\Models\IMDBID;

readonly class MovieRentData
{
    public function __construct(
        private IMDBID        $IMDBID,
        private MovieRentType $rentType,
        private int           $userID,
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

    public function getUserID(): int
    {
        return $this->userID;
    }
}
