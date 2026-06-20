<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewCommentNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly Comment $comment)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New comment received',
            'message' => $this->comment->user->name.' commented on "'.$this->comment->blog->title.'".',
            'blog_slug' => $this->comment->blog->slug,
        ];
    }
}
