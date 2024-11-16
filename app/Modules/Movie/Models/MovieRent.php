<?php

namespace App\Modules\Movie\Models;

use App\Modules\Movie\Enums\MovieRentType;
use App\Modules\Movie\Models\Casts\MovieIDCast;
use App\Modules\Movie\Models\Casts\MovieRentIDCast;
use App\Modules\Subscription\Models\Casts\DurationInMonthCast;
use App\Modules\Subscription\Models\Casts\PriceCast;
use App\Modules\User\Models\Casts\UserIDCast;
use App\Modules\User\Models\UserID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property MovieRentID $id
 * @property-read UserID $user_id
 * @property-read MovieID $movie_id
 * @property-read MovieRentType $duration
 * @property-read Carbon $expires_at
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * */
class MovieRent extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'id' => MovieRentIDCast::class,
            'user_id' => UserIDCast::class,
            'movie_id' => MovieIDCast::class,
            'duration' => MovieRentType::class,
            'duration_in_month' => DurationInMonthCast::class,
            'price' => PriceCast::class,
        ];
    }

    public static function new(
        MovieID       $movieId,
        UserID        $userID,
        MovieRentType $type,
    ): self
    {
        $movieRent = new self();

        $movieRent->movie_id = $movieId;
        $movieRent->user_id = $userID;
        $movieRent->duration = $type;
        $movieRent->expires_at = Carbon::now()->addHours($type->value);

        return $movieRent;
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }
}
