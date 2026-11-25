<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|in:movie,series',
            'genre' => 'sometimes|required|string|max:100',
            'release_year' => 'sometimes|required|integer|min:1888|max:' . date('Y'),
            'description' => 'sometimes|nullable|string',
        ];
    }
}