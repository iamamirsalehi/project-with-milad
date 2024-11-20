<?php

namespace App\Modules\Payment\Exceptions;

use App\Contracts\Exceptions\BusinessException;

class PaymentApplicationException extends BusinessException
{
    private const INVALID_PAYMENT_ID = 'invalid payment id';
    private const INVALID_PAYMENT_AMOUNT = 'invalid payment amount';
    private const INVALID_PAYMENT_METHOD = 'invalid payment method';
    private const PAYMENT_STATUS_IS_ALREADY_PAID = 'payment status is already paid';
    private const INVALID_INVOICE_ID = 'invalid invoice id';
    private const INVALID_INVOICE_TYPE_ID = 'invalid invoice type id';
    private const INVALID_INVOICE_PRICE = 'invalid invoice price';
    private const CAN_NOT_HAVE_TWO_UNPAID_INVOICE = 'can not have two unpaid invoice';
    private const INVOICE_DOES_NOT_EXIST = 'invoice does not exist';
    private const INVOICE_IS_ALREADY_PAID = 'invoice is already paid';

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

    public static function invalidInvoiceID(): self
    {
        return new self(self::INVALID_INVOICE_ID);
    }

    public static function invalidInvoiceTypeID(): self
    {
        return new self(self::INVALID_INVOICE_TYPE_ID);
    }

    public static function invalidInvoicePrice(): self
    {
        return new self(self::INVALID_INVOICE_PRICE);
    }

    public static function canNotHaveTwoUnpaidInvoice(): self
    {
        return new self(self::CAN_NOT_HAVE_TWO_UNPAID_INVOICE);
    }

    public static function invoiceDoesNotExist(): self
    {
        return new self(self::INVOICE_DOES_NOT_EXIST);
    }

    public static function invoiceIsAlreadyPaid(): self
    {
        return new self(self::INVOICE_IS_ALREADY_PAID);
    }
}
