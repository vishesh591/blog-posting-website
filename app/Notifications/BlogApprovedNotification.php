<?php

namespace App\Notifications;

use App\Models\Blog;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BlogApprovedNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly Blog $blog)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Blog approved',
            'message' => '"'.$this->blog->title.'" is approved and ready for publishing.',
            'blog_slug' => $this->blog->slug,
        ];
    }
}
