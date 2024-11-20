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
            'title' => $this->title,
            'language' => $this->language->toPrimitiveType(),
            'country' => $this->country->toPrimitiveType(),
            'poster' => $this->poster->toPrimitiveType(),
            'url' => $this->url,
            'imdbRating' => $this->imdb_rating->toPrimitiveType(),
            'imdbID' => $this->imdb_id->toPrimitiveType(),
            'imdbVotes' => $this->imdb_votes,
            'genres' => GenreResource::collection($this->genres),
        ];
    }
}
