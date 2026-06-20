<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(6);

        return [
            'author_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(100, 999),
            'excerpt' => fake()->sentence(18),
            'body' => '<p>'.implode('</p><p>', fake()->paragraphs(7)).'</p>',
            'seo_title' => $title,
            'seo_description' => fake()->sentence(22),
            'status' => fake()->randomElement(['published', 'draft', 'review']),
            'allow_comments' => true,
            'is_featured' => fake()->boolean(30),
            'is_trending' => fake()->boolean(25),
            'reading_time' => fake()->numberBetween(3, 12),
            'views_count' => fake()->numberBetween(50, 4500),
            'published_at' => now()->subDays(fake()->numberBetween(1, 40)),
        ];
    }
}
