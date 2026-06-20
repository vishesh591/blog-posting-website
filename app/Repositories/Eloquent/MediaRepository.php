<?php

namespace App\Repositories\Eloquent;

use App\Models\MediaFile;
use App\Repositories\Contracts\MediaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaRepository implements MediaRepositoryInterface
{
    public function paginateForUser(int $userId, int $perPage = 15): LengthAwarePaginator
    {
        return MediaFile::query()->where('user_id', $userId)->latest()->paginate($perPage);
    }

    public function store(UploadedFile $file, int $userId, ?int $folderId = null): MediaFile
    {
        $path = $file->store('media-library', 'public');

        return MediaFile::create([
            'user_id' => $userId,
            'folder_id' => $folderId,
            'path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType() ?: $file->getMimeType() ?: 'application/octet-stream',
            'size' => $file->getSize() ?: 0,
            'disk' => 'public',
        ]);
    }

    public function update(MediaFile $mediaFile, array $data): MediaFile
    {
        $mediaFile->update($data);

        return $mediaFile->fresh();
    }

    public function delete(MediaFile $mediaFile): void
    {
        Storage::disk($mediaFile->disk)->delete($mediaFile->path);
        $mediaFile->delete();
    }
}
