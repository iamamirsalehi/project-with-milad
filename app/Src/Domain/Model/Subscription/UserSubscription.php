<?php

namespace App\Src\Domain\Model\Subscription;

use App\Src\Domain\Enums\UserSubscriptionStatus;
use App\Src\Domain\Exceptions\MovieApplicationException;
use App\Src\Domain\Exceptions\SubscriptionApplicationExceptions;
use App\Src\Domain\Model\User\UserID;
use App\Src\Instrastructure\Cast\Subscription\ExpiresAtCast;
use App\Src\Instrastructure\Cast\Subscription\SubscriptionIDCast;
use App\Src\Instrastructure\Cast\Subscription\UserSubscriptionIDCast;
use App\Src\Instrastructure\Cast\User\UserIDCast;
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
final class UserSubscription extends Model
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
    public function activate(): void
    {
        if ($this->status == UserSubscriptionStatus::Active) {
            throw SubscriptionApplicationExceptions::userSubscriptionIsAlreadyActive();
        }

        $this->status = UserSubscriptionStatus::Active;
    }

    /**
     * @throws MovieApplicationException
     */
    public function watch(): void
    {
        if(!$this->isActive()){
            throw MovieApplicationException::movieIsNotAccessible();
        }
    }
}
