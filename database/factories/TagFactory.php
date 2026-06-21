<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    protected static array $tags = [
        'Programming', 'Web Development', 'Laravel', 'PHP', 'JavaScript', 'React', 'Vue',
        'CSS', 'HTML', 'Tailwind', 'Database', 'API', 'Docker', 'AWS', 'Python',
        'Healthy Eating', 'Fitness', 'Mental Health', 'Yoga', 'Meditation', 'Weight Loss',
        'Solo Travel', 'Backpacking', 'Budget Travel', 'Luxury Travel', 'Road Trips',
        'Baking', 'Vegan Recipes', 'Quick Meals', 'Desserts', 'Meal Prep',
        'Saving Money', 'Investing', 'Budgeting', 'Cryptocurrency', 'Real Estate',
        'Productivity', 'Time Management', 'Minimalism', 'Relationships', 'Home Decor',
        'Resume Writing', 'Interview Tips', 'Remote Work', 'Online Courses', 'Freelancing',
        'Entrepreneurship', 'Marketing', 'SEO', 'SaaS', 'Funding'
    ];

    public function definition(): array
    {
        $name = fake()->unique()->randomElement(self::$tags);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
