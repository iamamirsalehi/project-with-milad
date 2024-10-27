<?php

namespace App\Modules\Subscription\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property int $price
 * @property int $duration_in_month
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * */
class Subscription extends Model
{
    protected $guarded = [];

    public static function new(
        string $name,
        int    $price,
        int    $durationInMonth
    ): self
    {
        $newSubscription = new self();
        $newSubscription->name = $name;
        $newSubscription->price = $price;
        $newSubscription->duration_in_month = $durationInMonth;

        return $newSubscription;
    }
}
