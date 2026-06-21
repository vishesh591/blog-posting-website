<?php

namespace App\Models;

use Database\Factories\BlogFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'author_id',
    'approved_by_id',
    'category_id',
    'title',
    'slug',
    'excerpt',
    'body',
    'summary',
    'seo_title',
    'seo_description',
    'canonical_url',
    'featured_image_path',
    'status',
    'is_featured',
    'is_trending',
    'allow_comments',
    'reading_time',
    'views_count',
    'published_at',
    'scheduled_for',
])]
class Blog extends Model
{
    /** @use HasFactory<BlogFactory> */
    use HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'is_featured' => 'bool',
            'is_trending' => 'bool',
            'allow_comments' => 'bool',
            'published_at' => 'datetime',
            'scheduled_for' => 'datetime',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    public function mediaFiles(): MorphMany
    {
        return $this->morphMany(MediaFile::class, 'mediable');
    }

    public function readingHistories(): HasMany
    {
        return $this->hasMany(ReadingHistory::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where(function (Builder $builder) {
            $builder->where(function (Builder $published) {
                $published->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
            })->orWhere(function (Builder $scheduled) {
                $scheduled->where('status', 'scheduled')
                    ->whereNotNull('scheduled_for')
                    ->where('scheduled_for', '<=', now());
            });
        });
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->with(['author', 'category', 'tags', 'mediaFiles'])
            ->withCount(['likes', 'bookmarks', 'comments']);
    }
}
