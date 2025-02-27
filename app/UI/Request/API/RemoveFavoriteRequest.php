<?php

namespace App\UI\Request\API;

use Illuminate\Foundation\Http\FormRequest;

class RemoveFavoriteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|numeric|exists:users,id',
            'imdb_id' => 'required|string|exists:movies,imdb_id',
        ];
    }
}
