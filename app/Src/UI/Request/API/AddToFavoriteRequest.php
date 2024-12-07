<?php

namespace App\Src\UI\Request\API;

use Illuminate\Foundation\Http\FormRequest;

class AddToFavoriteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'imdb_id' => 'required|string|exists:movies,imdb_id',
            'user_id' => 'required|numeric|exists:users,id',
        ];
    }
}
