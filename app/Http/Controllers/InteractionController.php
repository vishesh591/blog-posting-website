<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\JsonResponse;

class InteractionController extends Controller
{
    public function like(Blog $blog): JsonResponse
    {
        $liked = ! $blog->likes()->where('user_id', auth()->id())->exists();

        $blog->likes()->where('user_id', auth()->id())->delete();

        if ($liked) {
            $blog->likes()->create(['user_id' => auth()->id()]);
        }

        return response()->json([
            'liked' => $liked,
            'count' => $blog->likes()->count(),
        ]);
    }

    public function bookmark(Blog $blog): JsonResponse
    {
        $bookmarked = ! $blog->bookmarks()->where('user_id', auth()->id())->exists();

        $blog->bookmarks()->where('user_id', auth()->id())->delete();

        if ($bookmarked) {
            $blog->bookmarks()->create(['user_id' => auth()->id()]);
        }

        return response()->json([
            'bookmarked' => $bookmarked,
            'count' => $blog->bookmarks()->count(),
        ]);
    }
}
