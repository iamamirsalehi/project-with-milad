<?php

namespace App\Modules\Favorite\Models;

use App\Modules\Movie\Models\Movie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property-read int $user_id
 * @property-read int $movie_id
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * */
class FavoriteMovie extends Model
{
    protected $guarded = [];

    public static function new(int $movieID, int $userID): self
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

    public function isRemoved(): bool
    {
        return !is_null($this->deleted_at);
    }
}
