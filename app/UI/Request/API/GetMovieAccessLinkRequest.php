<?php

namespace App\UI\Request\API;

use Illuminate\Foundation\Http\FormRequest;

class GetMovieAccessLinkRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|numeric|exists:users,id',
            'imdb_id' => 'required|numeric|exists:movies,imdb_id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
