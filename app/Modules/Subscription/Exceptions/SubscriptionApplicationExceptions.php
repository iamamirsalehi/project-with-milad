<?php

namespace App\Modules\Subscription\Exceptions;

use App\Contracts\Exceptions\BusinessException;

class SubscriptionApplicationExceptions extends BusinessException
{
    private const SUBSCRIPTION_ALREADY_EXISTS = 'subscription already exists';
    private const USER_CAN_NOT_HAVE_TWO_SUBSCRIPTIONS = 'user can not have two subscriptions';
    private const COULD_NOT_FIND_SUBSCRIPTION = 'could not find subscription';
    private const INVALID_EXPIRE_DATE = 'invalid expire date';

    public static function couldNotFindSubscription(): self
    {
        return new self(self::COULD_NOT_FIND_SUBSCRIPTION);
    }

    public static function subscriptionAlreadyExists(): self
    {
        return new self(self::SUBSCRIPTION_ALREADY_EXISTS);
    }

    public static function userCanNotHaveTwoSubscriptions(): self
    {
        return new self(self::USER_CAN_NOT_HAVE_TWO_SUBSCRIPTIONS);
    }

    public static function invalidExpireDate(): self
    {
        return new self(self::INVALID_EXPIRE_DATE);
    }
}
