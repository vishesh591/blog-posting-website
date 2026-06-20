<?php

namespace App\Jobs;

use App\Models\MediaFile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class ProcessMediaImage implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly MediaFile $mediaFile)
    {
    }

    public function handle(): void
    {
        $path = Storage::disk($this->mediaFile->disk)->path($this->mediaFile->path);

        if (! extension_loaded('gd') || ! is_file($path)) {
            return;
        }

        $metadata = @getimagesize($path);

        if (! $metadata) {
            return;
        }

        $this->mediaFile->update([
            'width' => $metadata[0] ?? null,
            'height' => $metadata[1] ?? null,
        ]);
    }
}
