<?php

namespace App\Src\Domain\Exceptions;

final class PaymentApplicationException extends BusinessException
{
    private const INVALID_PAYMENT_ID = 'invalid payment id';
    private const INVALID_PAYMENT_AMOUNT = 'invalid payment amount';
    private const INVALID_PAYMENT_METHOD = 'invalid payment method';
    private const PAYMENT_STATUS_IS_ALREADY_PAID = 'payment status is already paid';
    private const INVALID_PAYMENTABLE_TYPE = 'invalid paymentable type';
    private const INVALID_PAYMENTABLE_ID = 'invalid paymentable id';

    public static function invalidPaymentID(): self
    {
        return new self(self::INVALID_PAYMENT_ID);
    }

    public static function invalidPaymentAmount(): self
    {
        return new self(self::INVALID_PAYMENT_AMOUNT);
    }

    public static function invalidPaymentMethod(): self
    {
        return new self(self::INVALID_PAYMENT_METHOD);
    }

    public static function paymentStatusIsAlreadyPaid(): self
    {
        return new self(self::PAYMENT_STATUS_IS_ALREADY_PAID);
    }

    public static function invalidPaymentableType(): self
    {
        return new self(self::INVALID_PAYMENT_AMOUNT);
    }

    public static function invalidPaymentableId(): self
    {
        return new self(self::INVALID_PAYMENTABLE_ID);
    }
}
