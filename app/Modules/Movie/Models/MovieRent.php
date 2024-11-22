<?php

namespace App\Modules\Movie\Models;

use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Movie\Models\Casts\DurationCast;
use App\Modules\Movie\Models\Casts\ExpiresAtCast;
use App\Modules\Movie\Models\Casts\MovieIDCast;
use App\Modules\Movie\Models\Casts\MovieRentIDCast;
use App\Modules\Payment\Models\Payment;
use App\Modules\User\Models\Casts\UserIDCast;
use App\Modules\User\Models\UserID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;

/**
 * @property MovieRentID $id
 * @property-read UserID $user_id
 * @property-read MovieID $movie_id
 * @property-read Duration $duration
 * @property-read ExpiresAt $expires_at
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
            'duration' => DurationCast::class,
            'expires_at' => ExpiresAtCast::class,
        ];
    }

    public static function new(
        MovieID  $movieId,
        UserID   $userID,
        Duration $duration,
    ): self
    {
        $movieRent = new self();

        $movieRent->movie_id = $movieId;
        $movieRent->user_id = $userID;
        $movieRent->duration = $duration;

        return $movieRent;
    }

    public function isExpired(): bool
    {
        return $this->expires_at->toCarbon()->isPast();
    }

    /**
     * @throws MovieApplicationException
     */
    public function startWatching(): void
    {
        if ($this->isWatchingStarted()) {
            throw MovieApplicationException::movieRentIsAlreadyStartedToWatching();
        }

        $this->expires_at = new ExpiresAt(Carbon::now()->addHours($this->duration->toPrimitiveType()));
    }

    public function isWatchingStarted(): bool
    {
        return false === is_null($this->expires_at);
    }

    public function payment(): MorphOne
    {
        return $this->morphOne(Payment::class, 'paymentable');
    }
}
