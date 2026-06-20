<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Comment;
use App\Models\MediaFile;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BlogPlatformSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@inkpress.test',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $authors = User::factory(4)->create(['role' => 'author']);
        $readers = User::factory(8)->create(['role' => 'reader']);

        $categories = Category::factory(6)->create();
        $tags = Tag::factory(12)->create();

        $blogs = Blog::factory(18)
            ->recycle([$admin, ...$authors->all()])
            ->recycle($categories)
            ->create();

        $blogs->each(function (Blog $blog) use ($tags, $readers) {
            $blog->tags()->sync($tags->random(rand(2, 5))->pluck('id'));
            Comment::factory(rand(1, 4))->create([
                'blog_id' => $blog->id,
                'user_id' => $readers->random()->id,
            ]);
            $blog->likes()->createMany(
                $readers->random(rand(1, 4))->map(fn ($user) => ['user_id' => $user->id])->all()
            );
            $blog->bookmarks()->createMany(
                $readers->random(rand(1, 3))->map(fn ($user) => ['user_id' => $user->id])->all()
            );
            MediaFile::factory(rand(1, 2))->create([
                'user_id' => $blog->author_id,
                'mediable_id' => $blog->id,
                'mediable_type' => Blog::class,
            ]);
        });
    }
}
