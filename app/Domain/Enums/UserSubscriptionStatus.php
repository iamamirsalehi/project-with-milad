<?php

namespace App\Domain\Enums;

enum UserSubscriptionStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
}
