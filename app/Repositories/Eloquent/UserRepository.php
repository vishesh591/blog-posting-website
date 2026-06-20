<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function popularAuthors(int $limit = 5): Collection
    {
        return User::query()
            ->authors()
            ->withCount(['blogs as published_blogs_count' => fn ($builder) => $builder->published()])
            ->orderByDesc('published_blogs_count')
            ->limit($limit)
            ->get();
    }

    public function findAuthorById(int $id): User
    {
        return User::query()->authors()->with(['blogs' => fn ($builder) => $builder->visible()->published()->latest('published_at')])->findOrFail($id);
    }
}
