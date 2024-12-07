<?php

namespace App\Src\Instrastructure\Cast\Subscription;

use App\Src\Domain\Exceptions\SubscriptionApplicationExceptions;
use App\Src\Domain\Model\Subscription\UserSubscriptionID;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class UserSubscriptionIDCast implements CastsAttributes
{
    /**
     * @throws SubscriptionApplicationExceptions
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): UserSubscriptionID
    {
        return new UserSubscriptionID($value);
    }

    /**
     * @throws SubscriptionApplicationExceptions
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if($value instanceof UserSubscriptionID){
            return $value->toPrimitiveType();
        }

       return (new UserSubscriptionID($value))->toPrimitiveType();
    }
}
