<?php

namespace App\Modules\Subscription\Services\SubscriptionService;

readonly class SubscriptionData
{
    public function __construct(
        private string $name,
        private int    $price,
        private int    $durationInMonth,
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getDurationInMonth(): int
    {
        return $this->durationInMonth;
    }
}
