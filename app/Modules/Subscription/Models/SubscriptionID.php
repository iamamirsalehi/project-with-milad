<?php

namespace App\Modules\Subscription\Models;

use App\Modules\Subscription\Exceptions\SubscriptionApplicationExceptions;

final readonly class SubscriptionID
{
    /**
     * @throws SubscriptionApplicationExceptions
     */
    public function __construct(private int $id)
    {
        if ($this->id <= 0) {
            throw SubscriptionApplicationExceptions::invalidSubscriptionID();
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
