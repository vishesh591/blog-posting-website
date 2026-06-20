<?php

namespace App\Repositories\Contracts;

use App\Models\MediaFile;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;

interface MediaRepositoryInterface
{
    public function paginateForUser(int $userId, int $perPage = 15): LengthAwarePaginator;

    public function store(UploadedFile $file, int $userId, ?int $folderId = null): MediaFile;

    public function update(MediaFile $mediaFile, array $data): MediaFile;

    public function delete(MediaFile $mediaFile): void;
}
