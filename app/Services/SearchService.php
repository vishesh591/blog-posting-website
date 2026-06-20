<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Collection;

class SearchService
{
    public function suggestions(string $query): Collection
    {
        if ($query === '') {
            return collect();
        }

        return Blog::query()
            ->published()
            ->limit(6)
            ->where('title', 'like', '%'.$query.'%')
            ->pluck('title');
    }

    public function global(string $query): array
    {
        return [
            'blogs' => Blog::query()->visible()->published()->where('title', 'like', '%'.$query.'%')->limit(8)->get(),
            'categories' => Category::query()->where('name', 'like', '%'.$query.'%')->limit(6)->get(),
            'tags' => Tag::query()->where('name', 'like', '%'.$query.'%')->limit(6)->get(),
        ];
    }
}
