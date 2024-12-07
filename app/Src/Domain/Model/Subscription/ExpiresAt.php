<?php

namespace App\Src\Domain\Model\Subscription;

use App\Src\Domain\Exceptions\SubscriptionApplicationExceptions;
use Illuminate\Support\Carbon;

final readonly class ExpiresAt
{
    /**
     * @throws SubscriptionApplicationExceptions
     */
    public function __construct(private string $expiresAt)
    {
        if (Carbon::parse($this->expiresAt)->isPast()) {
            throw SubscriptionApplicationExceptions::invalidExpiresAt();
        }
    }

    public function toCarbon(): Carbon
    {
        return Carbon::parse($this->expiresAt);
    }

    public function __toString(): string
    {
        return $this->expiresAt;
    }
}
