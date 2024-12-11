<?php

namespace App\Domain\Model\Subscription;

use App\Domain\Exceptions\SubscriptionApplicationExceptions;

final readonly class UserSubscriptionID
{
    /**
     * @throws SubscriptionApplicationExceptions
     */
    public function __construct(private int $id)
    {
        if ($this->id <= 0) {
            throw SubscriptionApplicationExceptions::invalidUserSubscriptionID();
        }
    }

    public function toPrimitiveType(): int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->toPrimitiveType();
    }
}
