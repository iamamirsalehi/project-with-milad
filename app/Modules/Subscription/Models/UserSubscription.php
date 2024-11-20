<?php

namespace App\Modules\Subscription\Models;

use App\Modules\Subscription\Enums\UserSubscriptionStatus;
use App\Modules\Subscription\Exceptions\SubscriptionApplicationExceptions;
use App\Modules\Subscription\Models\Casts\ExpiresAtCast;
use App\Modules\Subscription\Models\Casts\SubscriptionIDCast;
use App\Modules\Subscription\Models\Casts\UserSubscriptionIDCast;
use App\Modules\User\Models\Casts\UserIDCast;
use App\Modules\User\Models\UserID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property       UserSubscriptionID $id
 * @property-read  UserID $user_id
 * @property-read  SubscriptionID $subscription_id
 * @property-read UserSubscriptionStatus $status
 * @property       ExpiresAt $expires_at
 * @property       Carbon $created_at
 * @property       Carbon $updated_at
 * */
class UserSubscription extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'id' => UserSubscriptionIDCast::class,
            'user_id' => UserIDCast::class,
            'subscription_id' => SubscriptionIDCast::class,
            'status' => UserSubscriptionStatus::class,
            'expires_at' => ExpiresAtCast::class,
        ];
    }

    public static function new(UserID $userID, SubscriptionID $subscriptionID, ExpiresAt $expiresAt): self
    {
        $userSubscription = new self();

        $userSubscription->user_id = $userID;
        $userSubscription->subscription_id = $subscriptionID;
        $userSubscription->status = UserSubscriptionStatus::Inactive;
        $userSubscription->expires_at = $expiresAt;

        return $userSubscription;
    }

    public function isActive(): bool
    {
        return $this->expires_at->toCarbon()->greaterThan(Carbon::now());
    }

    /**
     * @throws SubscriptionApplicationExceptions
     */
    public function active(): void
    {
        if ($this->status == UserSubscriptionStatus::Active) {
            throw SubscriptionApplicationExceptions::userSubscriptionIsAlreadyActive();
        }

        $this->status = UserSubscriptionStatus::Active;
    }
}
