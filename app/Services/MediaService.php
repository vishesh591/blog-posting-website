<?php

namespace App\Services;

use App\Jobs\ProcessMediaImage;
use App\Models\MediaFile;
use App\Repositories\Contracts\MediaRepositoryInterface;
use Illuminate\Http\UploadedFile;

class MediaService
{
    public function __construct(private readonly MediaRepositoryInterface $media)
    {
    }

    public function upload(UploadedFile $file, int $userId, ?int $folderId = null): MediaFile
    {
        $mediaFile = $this->media->store($file, $userId, $folderId);

        ProcessMediaImage::dispatch($mediaFile);

        return $mediaFile;
    }
}
