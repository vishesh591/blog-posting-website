<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'headline' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1200'],
            'avatar' => ['nullable', 'image', 'max:3072'],
            'social_links.twitter' => ['nullable', 'url'],
            'social_links.linkedin' => ['nullable', 'url'],
            'social_links.website' => ['nullable', 'url'],
        ];
    }
}
