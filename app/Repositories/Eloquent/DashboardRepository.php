<?php

namespace App\Repositories\Eloquent;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\MediaFile;
use App\Models\User;
use App\Repositories\Contracts\DashboardRepositoryInterface;

class DashboardRepository implements DashboardRepositoryInterface
{
    public function statsForUser(int $userId, string $role): array
    {
        $blogsQuery = Blog::query();

        if ($role !== 'admin') {
            $blogsQuery->where('author_id', $userId);
        }

        return [
            'total_users' => User::count(),
            'total_blogs' => (clone $blogsQuery)->count(),
            'published_blogs' => (clone $blogsQuery)->where('status', 'published')->count(),
            'draft_blogs' => (clone $blogsQuery)->where('status', 'draft')->count(),
            'most_viewed' => (clone $blogsQuery)->with('author')->orderByDesc('views_count')->take(5)->get(),
            'recent_activities' => collect([
                ...Blog::query()->latest()->take(4)->get()->map(fn ($blog) => ['label' => 'Blog updated', 'description' => $blog->title, 'time' => $blog->updated_at])->all(),
                ...Comment::query()->with('user', 'blog')->latest()->take(4)->get()->map(fn ($comment) => ['label' => 'New comment', 'description' => $comment->user->name.' on '.$comment->blog->title, 'time' => $comment->created_at])->all(),
                ...MediaFile::query()->latest()->take(2)->get()->map(fn ($media) => ['label' => 'Media uploaded', 'description' => $media->file_name, 'time' => $media->created_at])->all(),
            ])->sortByDesc('time')->take(8)->values(),
        ];
    }
}
