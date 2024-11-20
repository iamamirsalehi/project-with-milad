<?php

namespace App\Modules\Subscription\Enums;

enum UserSubscriptionStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
}
