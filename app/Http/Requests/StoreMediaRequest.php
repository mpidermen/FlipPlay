<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'type' => 'required|in:movie,series',
            'genre' => 'required|string|max:100',
            'release_year' => 'required|integer|min:1888|max:' . date('Y'),
            'description' => 'nullable|string',
        ];
    }
}