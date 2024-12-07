<?php

namespace App\Src\Domain\Repository;

use App\Src\Domain\Model\Payment\Payment;
use App\Src\Domain\Model\Payment\PaymentID;
use App\Src\Domain\Model\User\UserID;

interface IPaymentRepository
{
    public function findByID(PaymentID $id): ?Payment;

    public function findByUserID(UserID $userID): ?Payment;

    public function save(Payment $payment): void;
}
