<?php

namespace App\Repositories\Eloquent;

use App\Models\Blog;
use App\Repositories\Contracts\BlogRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BlogRepository implements BlogRepositoryInterface
{
    public function paginatePublic(array $filters = [], int $perPage = 9): LengthAwarePaginator
    {
        $query = Blog::query()->visible()->published()->latest('published_at');

        if (! empty($filters['search'])) {
            $query->where(fn ($builder) => $builder
                ->where('title', 'like', '%'.$filters['search'].'%')
                ->orWhere('excerpt', 'like', '%'.$filters['search'].'%')
                ->orWhere('body', 'like', '%'.$filters['search'].'%'));
        }

        if (! empty($filters['category'])) {
            $query->whereHas('category', fn ($builder) => $builder->where('slug', $filters['category']));
        }

        if (! empty($filters['tag'])) {
            $query->whereHas('tags', fn ($builder) => $builder->where('slug', $filters['tag']));
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function paginateDashboard(?int $authorId = null, int $perPage = 10): LengthAwarePaginator
    {
        $query = Blog::query()->with(['category', 'author', 'tags'])->latest();

        if ($authorId) {
            $query->where('author_id', $authorId);
        }

        return $query->paginate($perPage);
    }

    public function featured(int $limit = 4): Collection
    {
        return Blog::query()->visible()->published()->where('is_featured', true)->latest('published_at')->limit($limit)->get();
    }

    public function trending(int $limit = 5): Collection
    {
        return Blog::query()->visible()->published()->orderByDesc('views_count')->orderByDesc('likes_count')->limit($limit)->get();
    }

    public function recent(int $limit = 6): Collection
    {
        return Blog::query()->visible()->published()->latest('published_at')->limit($limit)->get();
    }

    public function popular(int $limit = 6): Collection
    {
        return Blog::query()->visible()->published()->orderByDesc('bookmarks_count')->orderByDesc('views_count')->limit($limit)->get();
    }

    public function findBySlug(string $slug, bool $includeUnpublished = false): Blog
    {
        $query = Blog::query()->visible()->where('slug', $slug);

        if (! $includeUnpublished) {
            $query->published();
        }

        return $query->firstOrFail();
    }

    public function related(Blog $blog, int $limit = 3): Collection
    {
        return Blog::query()
            ->visible()
            ->published()
            ->whereKeyNot($blog->id)
            ->where(function ($builder) use ($blog) {
                $builder->where('category_id', $blog->category_id)
                    ->orWhereHas('tags', fn ($tagBuilder) => $tagBuilder->whereIn('tags.id', $blog->tags->pluck('id')));
            })
            ->limit($limit)
            ->get();
    }

    public function create(array $data): Blog
    {
        $blog = Blog::create($data);
        $blog->tags()->sync($data['tag_ids'] ?? []);

        return $blog->load(['author', 'category', 'tags']);
    }

    public function update(Blog $blog, array $data): Blog
    {
        $blog->update($data);
        $blog->tags()->sync($data['tag_ids'] ?? []);

        return $blog->load(['author', 'category', 'tags']);
    }

    public function delete(Blog $blog): void
    {
        $blog->delete();
    }
}
