<?php

namespace App\Modules\Subscription\Models;

use App\Modules\Payment\Models\Payment;
use App\Modules\Subscription\Models\Casts\DurationInMonthCast;
use App\Modules\Subscription\Models\Casts\PriceCast;
use App\Modules\Subscription\Models\Casts\SubscriptionIDCast;
use App\Modules\User\Models\UserID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;

/**
 * @property      SubscriptionID $id
 * @property-read string $name
 * @property-read Price $price
 * @property-read DurationInMonth $duration_in_month
 * @property      Carbon $created_at
 * @property      Carbon $updated_at
 * */
class Subscription extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'id' => SubscriptionIDCast::class,
            'price' => PriceCast::class,
            'duration_in_month' => DurationInMonthCast::class,
        ];
    }

    public static function new(
        string          $name,
        Price           $price,
        DurationInMonth $durationInMonth
    ): self
    {
        $newSubscription = new self();
        $newSubscription->name = $name;
        $newSubscription->price = $price;
        $newSubscription->duration_in_month = $durationInMonth;

        return $newSubscription;
    }

    public function subscribe(UserID $userID, ExpiresAt $expiresAt): UserSubscription
    {
        return UserSubscription::new($userID, $this->id, $expiresAt);
    }

    public function payment(): MorphOne
    {
        return $this->morphOne(Payment::class, 'paymentable');
    }
}
