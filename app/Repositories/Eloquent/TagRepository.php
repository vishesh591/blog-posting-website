<?php

namespace App\Repositories\Eloquent;

use App\Models\Tag;
use App\Repositories\Contracts\TagRepositoryInterface;
use Illuminate\Support\Collection;

class TagRepository implements TagRepositoryInterface
{
    public function all(): Collection
    {
        return Tag::query()->withCount('blogs')->orderBy('name')->get();
    }
}
