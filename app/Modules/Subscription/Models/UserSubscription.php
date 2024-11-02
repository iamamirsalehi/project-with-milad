<?php

namespace App\Modules\Subscription\Models;

use App\Modules\Subscription\Exceptions\SubscriptionApplicationExceptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property       int $id
 * @property-read  int $user_id
 * @property-read  int $subscription_id
 * @property       Carbon $expires_at
 * @property       Carbon $created_at
 * @property       Carbon $updated_at
 * */
class UserSubscription extends Model
{
    protected $guarded = [];

    /**
     * @throws SubscriptionApplicationExceptions
     */
    public static function new(int $userID, int $subscriptionID, Carbon $expiresAt): self
    {
        if ($expiresAt->isPast()) {
            throw SubscriptionApplicationExceptions::invalidExpireDate();
        }

        $userSubscription = new self();

        $userSubscription->user_id = $userID;
        $userSubscription->subscription_id = $subscriptionID;
        $userSubscription->expires_at = $expiresAt;

        return $userSubscription;
    }

    public function isActive(): bool
    {
        return $this->expires_at > Carbon::now();
    }
}
