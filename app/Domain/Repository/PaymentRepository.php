<?php

namespace App\Domain\Repository;

use App\Domain\Model\Payment\Payment;
use App\Domain\Model\Payment\PaymentID;
use App\Domain\Model\User\UserID;

interface PaymentRepository
{
    public function findByID(PaymentID $id): ?Payment;

    public function findByUserID(UserID $userID): ?Payment;

    public function save(Payment $payment): void;
}
