<?php

namespace App\Src\Instrastructure\Persistance\Repository\Eloquent;

use App\Src\Domain\Model\Payment\Payment;
use App\Src\Domain\Model\Payment\PaymentID;
use App\Src\Domain\Model\User\UserID;
use App\Src\Domain\Repository\IPaymentRepository;

class PaymentRepository extends EloquentBaseRepository implements IPaymentRepository
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
