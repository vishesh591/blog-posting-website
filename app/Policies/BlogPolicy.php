<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;

class BlogPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(?User $user, Blog $blog): bool
    {
        if (! $user) {
            return in_array($blog->status, ['published', 'scheduled'], true);
        }

        return $user->canManageBlog($blog) || in_array($blog->status, ['published', 'scheduled'], true);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'author'], true);
    }

    public function update(User $user, Blog $blog): bool
    {
        return $user->canManageBlog($blog);
    }

    public function delete(User $user, Blog $blog): bool
    {
        return $user->canManageBlog($blog);
    }

    public function publish(User $user, Blog $blog): bool
    {
        return $user->canManageBlog($blog);
    }
}
