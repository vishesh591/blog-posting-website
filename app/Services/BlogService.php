<?php

namespace App\Services;

use App\Models\Blog;
use App\Repositories\Contracts\BlogRepositoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class BlogService
{
    public function __construct(private readonly BlogRepositoryInterface $blogs)
    {
    }

    public function create(array $data): Blog
    {
        $payload = $this->hydratePayload($data);

        $this->clearCache();

        $blog = $this->blogs->create($payload);

        \App\Jobs\GenerateBlogSummaryJob::dispatch($blog);

        return $blog;
    }

    public function update(Blog $blog, array $data): Blog
    {
        $payload = $this->hydratePayload($data, $blog);

        $this->clearCache();

        $oldBody = $blog->body;
        $updatedBlog = $this->blogs->update($blog, $payload);

        if ($oldBody !== $updatedBlog->body || empty($updatedBlog->summary)) {
            \App\Jobs\GenerateBlogSummaryJob::dispatch($updatedBlog);
        }

        return $updatedBlog;
    }

    public function delete(Blog $blog): void
    {
        $this->clearCache();
        $this->blogs->delete($blog);
    }

    private function clearCache(): void
    {
        try {
            Cache::tags(['blogs'])->flush();
        } catch (\BadMethodCallException $e) {
            Cache::flush();
        }
    }

    private function hydratePayload(array $data, ?Blog $blog = null): array
    {
        $title = $data['title'];
        $body = $data['body'];
        $status = $data['status'] ?? 'draft';
        $scheduledFor = Arr::get($data, 'scheduled_for');

        return [
            ...$data,
            'slug' => $blog && $blog->title === $title ? $blog->slug : Str::slug($title).'-'.Str::lower(Str::random(4)),
            'reading_time' => max(1, (int) ceil(str_word_count(strip_tags($body)) / 200)),
            'status' => $scheduledFor ? 'scheduled' : $status,
            'published_at' => $status === 'published' && ! $scheduledFor ? now() : ($blog?->published_at),
            'scheduled_for' => $scheduledFor ?: null,
            'tag_ids' => $data['tag_ids'] ?? [],
        ];
    }
}
