<?php

namespace App\Modules\Movie\Models;

use App\Modules\Movie\Enums\MovieRentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property-read int $user_id
 * @property-read int $movie_id
 * @property-read MovieRentType $duration
 * @property-read Carbon $expires_at
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * */
class MovieRent extends Model
{
    protected $guarded = [];

    public static function new(
        int           $movieId,
        int           $userID,
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
