<?php

namespace App\Domain\Model\Favorite;

use App\Domain\Model\Movie\Movie;
use App\Domain\Model\Movie\MovieID;
use App\Domain\Model\User\UserID;
use App\Infrastructure\Cast\Favorite\FavoriteIDCast;
use App\Infrastructure\Cast\Movie\MovieIDCast;
use App\Infrastructure\Cast\User\UserIDCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property-read UserID $user_id
 * @property-read MovieID $movie_id
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * */
final class FavoriteMovie extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'id' => FavoriteIDCast::class,
            'user_id' => UserIDCast::class,
            'movie_id' => MovieIDCast::class,
        ];
    }

    public static function new(MovieID $movieID, UserID $userID): self
    {
        $favorite = new self();
        $favorite->movie_id = $movieID;
        $favorite->user_id = $userID;

        return $favorite;
    }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
}
