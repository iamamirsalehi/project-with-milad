<?php

namespace App\Src\Instrastructure\Cast\Movie;

use App\Src\Domain\Exceptions\MovieApplicationException;
use App\Src\Domain\Model\Movie\IMDBVote;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

final class IMDBVoteCast implements CastsAttributes
{
    /**
     * @throws MovieApplicationException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): IMDBVote
    {
        return new IMDBVote($value);
    }

    /**
     * @throws MovieApplicationException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof IMDBVote) {
            return $value->toPrimitiveType();
        }

        return (new IMDBVote($value))->toPrimitiveType();
    }
}
