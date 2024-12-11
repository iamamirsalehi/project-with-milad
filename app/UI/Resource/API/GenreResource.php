<?php

namespace App\UI\Resource\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GenreResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name_en' => $this->name_en
        ];
    }
}
