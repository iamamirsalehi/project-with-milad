<?php

namespace App\Modules\Subscription\Models\Casts;

use App\Modules\Subscription\Exceptions\SubscriptionApplicationExceptions;
use App\Modules\Subscription\Models\SubscriptionID;
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
