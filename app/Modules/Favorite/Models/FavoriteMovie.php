<?php

namespace App\Modules\Favorite\Models;

use App\Modules\Favorite\Models\Casts\FavoriteIDCast;
use App\Modules\Movie\Models\Casts\MovieIDCast;
use App\Modules\Movie\Models\Movie;
use App\Modules\Movie\Models\MovieID;
use App\Modules\User\Models\Casts\UserIDCast;
use App\Modules\User\Models\UserID;
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
class FavoriteMovie extends Model
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
