<?php

namespace App\Models;

use Database\Factories\MediaFileFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable([
    'user_id',
    'folder_id',
    'mediable_id',
    'mediable_type',
    'disk',
    'path',
    'file_name',
    'mime_type',
    'size',
    'width',
    'height',
    'alt_text',
    'crop_data',
    'conversions',
])]
class MediaFile extends Model
{
    /** @use HasFactory<MediaFileFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'crop_data' => 'array',
            'conversions' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function folder(): BelongsTo
    {
        return $this->belongsTo(MediaFolder::class, 'folder_id');
    }

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }
}
