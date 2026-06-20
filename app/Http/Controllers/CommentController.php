<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Blog;
use App\Models\Comment;
use App\Notifications\NewCommentNotification;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, Blog $blog): RedirectResponse
    {
        $comment = $blog->comments()->create([
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
            'body' => $request->body,
        ]);

        $blog->author->notify(new NewCommentNotification($comment->load('user', 'blog')));

        return back()->with('success', 'Comment posted successfully.');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }
}
