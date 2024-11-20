<?php

namespace App\Http\Controllers\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;

class WatchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'imdb_id' => 'required|string|exists:movies,imdb_id',
            'user_id' => 'required|numeric|exists:users,id',
        ];
    }
}
