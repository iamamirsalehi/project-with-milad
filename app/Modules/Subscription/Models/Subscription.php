<?php

namespace App\Modules\Subscription\Models;

use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Movie\Models\DurationInMonth;
use App\Modules\Movie\Models\Price;
use App\Modules\Subscription\Exceptions\SubscriptionApplicationExceptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property      int $id
 * @property-read string $name
 * @property-read int $price
 * @property-read int $duration_in_month
 * @property      Carbon $created_at
 * @property      Carbon $updated_at
 * */
class Subscription extends Model
{
    protected $guarded = [];

    /**
     * @throws MovieApplicationException
     */
    public static function new(
        string          $name,
        Price           $price,
        DurationInMonth $durationInMonth
    ): self
    {
        $newSubscription = new self();
        $newSubscription->name = $name;
        $newSubscription->price = $price->get();
        $newSubscription->duration_in_month = $durationInMonth->get();

        return $newSubscription;
    }

    /**
     * @throws SubscriptionApplicationExceptions
     */
    public function subscribe(int $userID, Carbon $expiresAt): UserSubscription
    {
        return UserSubscription::new($userID, $this->id, $expiresAt);
    }
}
