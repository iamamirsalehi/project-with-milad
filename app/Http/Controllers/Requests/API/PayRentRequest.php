<?php

namespace App\Http\Controllers\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class PayRentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'imdb_id' => 'required|string|exists:movies,imdb_id',
            'user_id' => 'required|numeric|exists:users,id',
            'hours' => 'required|numeric',
            'method' => 'required|string',
        ];
    }
}
