<?php

namespace App\Modules\Payment\Services\PaymentService;

use App\Modules\Movie\Models\Duration;
use App\Modules\Movie\Models\IMDBID;
use App\Modules\Payment\Enums\PaymentMethod;
use App\Modules\User\Models\UserID;

readonly class NewMovieRentPayment
{
    public function __construct(
        private UserID $userID,
        private IMDBID $IMDBID,
        private Duration $duration,
        private PaymentMethod $paymentMethod,
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

    public function getPaymentMethod(): PaymentMethod
    {
        return $this->paymentMethod;
    }
}
