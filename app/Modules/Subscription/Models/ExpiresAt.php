<?php

namespace App\Modules\Subscription\Models;

use App\Modules\Subscription\Exceptions\SubscriptionApplicationExceptions;
use Illuminate\Support\Carbon;

readonly class ExpiresAt
{
    /**
     * @throws SubscriptionApplicationExceptions
     */
    public function __construct(private Carbon $expiresAt)
    {
        if ($this->expiresAt->isPast()) {
            throw SubscriptionApplicationExceptions::invalidExpiresAt();
        }
    }

    public function toCarbon(): Carbon
    {
        return $this->expiresAt;
    }

    public function __toString(): string
    {
        return $this->expiresAt->toDateTimeString();
    }
}
