<?php

namespace App\Application\Command;

use App\Domain\Model\Movie\Duration;
use App\Domain\Model\Movie\IMDBID;
use App\Domain\Model\User\UserID;

final readonly class PayRentCommand
{
    public function __construct(
        public UserID   $userID,
        public IMDBID   $IMDBID,
        public Duration $duration,
        public string   $paymentMethod,
    )
    {
    }
}
