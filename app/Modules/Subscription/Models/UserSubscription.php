<?php

namespace App\Modules\Subscription\Models;

use App\Modules\Subscription\Exceptions\SubscriptionApplicationExceptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int $subscription_id
 * @property Carbon $expires_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * */
class UserSubscription extends Model
{
    protected $guarded = [];

    public function subscribe(int $userID, int $subscriptionID, Carbon $expiresAt): void
    {
        if ($expiresAt->isPast()) {
            throw SubscriptionApplicationExceptions::invalidExpireDate();
        }

        $this->user_id = $userID;
        $this->subscription_id = $subscriptionID;
        $this->expires_at = $expiresAt;
    }

    public function isActive(): bool
    {
        return $this->expires_at > Carbon::now();
    }
}
