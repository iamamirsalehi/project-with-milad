<?php

namespace App\Application\Command;

use App\Domain\Model\Subscription\DurationInMonth;
use App\Domain\Model\Subscription\Price;

final readonly class AddSubscriptionCommand
{
    public function __construct(
        public string          $name,
        public Price           $price,
        public DurationInMonth $durationInMonth,
    )
    {
    }
}
