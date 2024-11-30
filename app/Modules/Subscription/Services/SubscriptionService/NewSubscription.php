<?php

namespace App\Modules\Subscription\Services\SubscriptionService;

use App\Modules\Subscription\Models\DurationInMonth;
use App\Modules\Subscription\Models\Price;

final readonly class NewSubscription
{
    public function __construct(
        private string          $name,
        private Price           $price,
        private DurationInMonth $durationInMonth,
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function getDurationInMonth(): DurationInMonth
    {
        return $this->durationInMonth;
    }
}
