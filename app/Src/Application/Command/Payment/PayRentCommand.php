<?php

namespace App\Src\Application\Command\Payment;

use App\Src\Domain\Model\Movie\Duration;
use App\Src\Domain\Model\Movie\IMDBID;
use App\Src\Domain\Model\User\UserID;

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
