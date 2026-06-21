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
    protected static array $titles = [
        '10 Tips for Mastering Laravel and PHP',
        'The Ultimate Guide to Modern CSS Layouts',
        'How to Stay Productive While Working Remotely',
        'A Beginner\'s Guide to Investing in Cryptocurrency',
        'Top 5 Destinations for Solo Backpackers',
        'Healthy and Delicious Vegan Recipes for Busy Weeknights',
        'Understanding the Basics of Database Indexing',
        'Why You Should Learn React in 2026',
        'The Art of Minimalism: Decluttering Your Life',
        'How to Prepare for Your Next Technical Interview',
        'An Introduction to Cloud Computing with AWS',
        'The Best Way to Organize Your Codebase',
        'Building Beautiful User Interfaces with Tailwind CSS',
        'A Deep Dive into Laravel Eloquent Relationships',
        'How to Create a Successful SaaS Product',
        'Essential Time Management Techniques for Developers',
        'The Future of Web Development: What to Expect',
        'How to Budget Your Money and Save More Every Month',
        'Exploring the Wonders of Deep Space and Science',
        'Creative Art and Design Projects to Inspire You'
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        try {
            $title = fake()->unique()->randomElement(self::$titles);
        } catch (\OverflowException $e) {
            $title = rtrim(fake()->realText(50), '.') . ' ' . fake()->unique()->numberBetween(1000, 9999);
        }

        $body = '<p>'.implode('</p><p>', [fake()->realText(400), fake()->realText(600), fake()->realText(500)]).'</p>';
        $summary = app(\App\Services\BlogSummarizerService::class)->summarize($body);

        return [
            'author_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(100, 999),
            'excerpt' => fake()->realText(150),
            'body' => $body,
            'summary' => $summary,
            'seo_title' => $title,
            'seo_description' => fake()->realText(150),
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
