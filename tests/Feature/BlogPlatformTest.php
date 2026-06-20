<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogPlatformTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_render(): void
    {
        $category = Category::factory()->create();
        $blog = Blog::factory()->create([
            'category_id' => $category->id,
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        $this->get(route('home'))->assertOk();
        $this->get(route('blogs.index'))->assertOk();
        $this->get(route('blogs.show', $blog->slug))->assertOk();
    }

    public function test_verified_user_can_access_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'author',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user)->get(route('dashboard.index'))->assertOk();
    }
}
