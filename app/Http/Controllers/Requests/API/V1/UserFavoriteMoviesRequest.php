<?php

namespace App\Http\Controllers\Requests\API\V1;

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
