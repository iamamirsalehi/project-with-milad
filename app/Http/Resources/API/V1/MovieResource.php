<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->movie->title,
            'language' => $this->movie->language,
            'country' => $this->movie->country,
            'poster' => $this->movie->poster,
            'url' => $this->movie->url,
            'imdbRating' => $this->movie->imdb_rating,
            'imdbID' => $this->movie->imdb_id,
            'imdbVotes' => $this->movie->imdb_votes,
        ];
    }
}
