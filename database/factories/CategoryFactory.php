<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    protected static array $categories = [
        'Technology',
        'Health & Wellness',
        'Travel & Adventure',
        'Food & Recipes',
        'Personal Finance',
        'Lifestyle & Fashion',
        'Career & Education',
        'Business & Startups',
        'Science & Space',
        'Art & Design',
    ];

    public function definition(): array
    {
        $name = fake()->unique()->randomElement(self::$categories);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->realText(100),
            'color' => fake()->randomElement(['#0f172a', '#f97316', '#14b8a6', '#0ea5e9']),
        ];
    }
}
