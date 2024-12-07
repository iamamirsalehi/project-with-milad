<?php

namespace App\Src\Instrastructure\Cast\Subscription;

use App\Src\Domain\Exceptions\SubscriptionApplicationExceptions;
use App\Src\Domain\Model\Subscription\SubscriptionID;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class SubscriptionIDCast implements CastsAttributes
{
    /**
     * @throws SubscriptionApplicationExceptions
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): SubscriptionID
    {
        return new SubscriptionID($value);
    }

    /**
     * @throws SubscriptionApplicationExceptions
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof SubscriptionID) {
            return $value->toPrimitiveType();
        }

        return (new SubscriptionID($value))->toPrimitiveType();
    }
}
