<?php

namespace App\Modules\Subscription\Models\Casts;

use App\Modules\Subscription\Exceptions\SubscriptionApplicationExceptions;
use App\Modules\Subscription\Models\ExpiresAt;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class ExpiresAtCast implements CastsAttributes
{
    /**
     * @throws SubscriptionApplicationExceptions
     */
    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        return new ExpiresAt($value);
    }

    /**
     * @throws SubscriptionApplicationExceptions
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof ExpiresAt) {
            return $value->toCarbon();
        }

        return (new ExpiresAt($value))->toCarbon();
    }
}
