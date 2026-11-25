<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('media', 'title')->ignore($this->route('media')),
            ],
            'type' => 'sometimes|required|in:movie,series',
            'genre' => 'sometimes|required|string|max:100',
            'release_year' => 'sometimes|required|integer|min:1888|max:' . date('Y'),
            'description' => 'sometimes|nullable|string',
        ];
    }
}