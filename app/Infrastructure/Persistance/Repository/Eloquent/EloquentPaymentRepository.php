<?php

namespace App\Infrastructure\Persistance\Repository\Eloquent;

use App\Domain\Model\Payment\Payment;
use App\Domain\Model\Payment\PaymentID;
use App\Domain\Model\User\UserID;
use App\Domain\Repository\PaymentRepository;

class EloquentPaymentRepository extends EloquentBaseRepository implements PaymentRepository
{
    public function findByUserID(UserID $userID): ?Payment
    {
        return $this->model->newQuery()
            ->where('user_id', $userID)
            ->first();
    }

    public function save(Payment $payment): void
    {
        $payment->save();
    }

    public function findByID(PaymentID $id): ?Payment
    {
        return $this->model->newQuery()
            ->where('id', $id)
            ->first();
    }
}
