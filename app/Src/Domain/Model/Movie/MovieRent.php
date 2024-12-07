<?php

namespace App\Src\Domain\Model\Movie;

use App\Src\Domain\Exceptions\MovieApplicationException;
use App\Src\Domain\Model\Payment\Payment;
use App\Src\Domain\Model\User\UserID;
use App\Src\Instrastructure\Cast\Movie\DurationCast;
use App\Src\Instrastructure\Cast\Movie\ExpiresAtCast;
use App\Src\Instrastructure\Cast\Movie\MovieIDCast;
use App\Src\Instrastructure\Cast\Movie\MovieRentIDCast;
use App\Src\Instrastructure\Cast\User\UserIDCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;

/**
 * @property MovieRentID $id
 * @property-read UserID $user_id
 * @property-read MovieID $movie_id
 * @property-read Duration $duration
 * @property-read ExpiresAt $expires_at
 * @property-read bool $is_active
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * */
final class MovieRent extends Model
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
            'is_active' => 'boolean',
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
        $movieRent->is_active = false;

        return $movieRent;
    }

    public function isExpired(): bool
    {
        return $this->expires_at->toCarbon()->isPast();
    }

    /**
     * @throws MovieApplicationException
     */
    public function watch(): void
    {
        if (!$this->isActive()) {
            throw MovieApplicationException::movieIsNotAccessible();
        }

        if ($this->isExpired()) {
            throw MovieApplicationException::movieIsNotAccessible();
        }

        if ($this->isWatchingStarted()) {
            return;
        }

        $this->startWatching();
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

    /**
     * @throws MovieApplicationException
     */
    public function activate(): void
    {
        if ($this->is_active) {
            throw MovieApplicationException::movieRentIsAlreadyActivated();
        }

        $this->is_active = true;
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function payment(): MorphOne
    {
        return $this->morphOne(Payment::class, 'paymentable');
    }
}
