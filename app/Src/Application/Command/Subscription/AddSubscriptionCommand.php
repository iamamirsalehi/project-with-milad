<?php

namespace App\Src\Application\Command\Subscription;

use App\Src\Domain\Model\Subscription\DurationInMonth;
use App\Src\Domain\Model\Subscription\Price;

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
