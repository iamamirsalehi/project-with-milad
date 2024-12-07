<?php

namespace App\Src\Domain\Model\Payment;

use App\Modules\Payment\Enums\PaymentMethod;
use App\Src\Domain\Enums\PaymentStatus;
use App\Src\Domain\Exceptions\PaymentApplicationException;
use App\Src\Domain\Model\User\UserID;
use App\Src\Instrastructure\Cast\Payment\PaymentIDCast;
use App\Src\Instrastructure\Cast\User\UserIDCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * @property-read PaymentID $id
 * @property-read UserID $user_id
 * @property-read Amount $amount
 * @property-read PaymentableType $paymentable_type
 * @property-read PaymentableID $paymentable_id
 * @property-read PaymentStatus $status
 * @property-read PaymentMethod $method
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * */
final class Payment extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'id' => PaymentIDCast::class,
            'user_id' => UserIDCast::class,
            'status' => PaymentStatus::class,
            'method' => PaymentMethod::class,
        ];
    }

    public static function new(
        UserID          $userID,
        Amount          $amount,
        PaymentableType $paymentableType,
        PaymentableID   $paymentableID,
        string $method
    ): self
    {
        $payment = new self();

        $payment->user_id = $userID;
        $payment->amount = $amount;
        $payment->paymentable_type = $paymentableType;
        $payment->paymentable_id = $paymentableID;
        $payment->status = PaymentStatus::Unpaid;
        $payment->method = $method;

        return $payment;
    }

    /**
     * @throws PaymentApplicationException
     */
    public function pay(): void
    {
        if ($this->status === PaymentStatus::Paid) {
            throw PaymentApplicationException::paymentStatusIsAlreadyPaid();
        }

        $this->status = PaymentStatus::Paid;
    }

    public function paymentable(): MorphTo
    {
        return $this->morphTo();
    }
}
