<?php

namespace App\UI\Request\API;

use Illuminate\Foundation\Http\FormRequest;

class UserFavoriteMoviesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|numeric|exists:users,id',
        ];
    }
}
