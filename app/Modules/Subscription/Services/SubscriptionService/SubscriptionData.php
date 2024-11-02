<?php

namespace App\Modules\Subscription\Services\SubscriptionService;

use App\Modules\Movie\Models\DurationInMonth;
use App\Modules\Movie\Models\Price;

readonly class SubscriptionData
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
