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
            'file' => ['nullable', 'image', 'max:5120'],
            'folder_id' => ['nullable', 'exists:media_folders,id'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'crop_data' => ['nullable', 'array'],
        ];
    }
}
