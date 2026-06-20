<?php

namespace App\Repositories\Contracts;

use App\Models\Blog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface BlogRepositoryInterface
{
    public function paginatePublic(array $filters = [], int $perPage = 9): LengthAwarePaginator;

    public function paginateDashboard(?int $authorId = null, int $perPage = 10): LengthAwarePaginator;

    public function featured(int $limit = 4): Collection;

    public function trending(int $limit = 5): Collection;

    public function recent(int $limit = 6): Collection;

    public function popular(int $limit = 6): Collection;

    public function findBySlug(string $slug, bool $includeUnpublished = false): Blog;

    public function related(Blog $blog, int $limit = 3): Collection;

    public function create(array $data): Blog;

    public function update(Blog $blog, array $data): Blog;

    public function delete(Blog $blog): void;
}
