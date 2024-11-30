<?php

namespace App\Modules\Payment\Services\PaymentService;

use App\Modules\Movie\Models\Duration;
use App\Modules\Movie\Models\IMDBID;
use App\Modules\User\Models\UserID;

final readonly class NewMovieRentPayment
{
    public function __construct(
        private UserID $userID,
        private IMDBID $IMDBID,
        private Duration $duration,
        private string $paymentMethod,
    )
    {
    }

    public function getUserID(): UserID
    {
        return $this->userID;
    }

    public function getDuration(): Duration
    {
        return $this->duration;
    }

    public function getIMDBID(): IMDBID
    {
        return $this->IMDBID;
    }

    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }
}
