<?php

namespace Database\Factories;

use App\Models\MediaFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFileFactory extends Factory
{
    protected $model = MediaFile::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'disk' => 'public',
            'path' => 'media-library/sample-'.fake()->uuid().'.jpg',
            'file_name' => fake()->randomElement(['office', 'workspace', 'nature', 'technology', 'coffee', 'laptop', 'coding', 'meeting', 'design', 'strategy']).'-'.fake()->numberBetween(1, 100).'.jpg',
            'mime_type' => 'image/jpeg',
            'size' => fake()->numberBetween(150000, 1500000),
            'width' => 1600,
            'height' => 900,
            'alt_text' => rtrim(fake()->realText(40), '.'),
        ];
    }
}
