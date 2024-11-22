<?php

namespace App\Contracts\Repositories;

use App\Modules\Payment\Models\Payment;
use App\Modules\Payment\Models\PaymentID;
use App\Modules\User\Models\UserID;

interface IPaymentRepository
{
    public function findByID(PaymentID $id): ?Payment;

    public function findByUserID(UserID $userID): ?Payment;

    public function save(Payment $payment): void;
}
