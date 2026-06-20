<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Models\MediaFile;
use App\Repositories\Contracts\MediaRepositoryInterface;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MediaLibraryController extends Controller
{
    public function __construct(
        private readonly MediaRepositoryInterface $media,
        private readonly MediaService $mediaService,
    ) {
    }

    public function index(): View
    {
        return view('dashboard.media.index', [
            'mediaItems' => $this->media->paginateForUser(auth()->id()),
        ]);
    }

    public function store(StoreMediaRequest $request): JsonResponse
    {
        $this->authorize('create', MediaFile::class);
        abort_unless($request->hasFile('file'), 422, 'A media file is required.');

        $mediaFile = $this->mediaService->upload($request->file('file'), auth()->id(), $request->folder_id);
        $this->media->update($mediaFile, [
            'alt_text' => $request->alt_text,
            'crop_data' => $request->crop_data,
        ]);

        return response()->json([
            'message' => 'Media uploaded successfully.',
            'item' => $mediaFile->fresh(),
            'url' => asset('storage/'.$mediaFile->path),
        ]);
    }

    public function update(StoreMediaRequest $request, MediaFile $media): RedirectResponse
    {
        $this->authorize('update', $media);

        $payload = $request->safe()->only(['alt_text', 'crop_data', 'folder_id']);

        if ($request->hasFile('file')) {
            $replacement = $this->mediaService->upload($request->file('file'), auth()->id(), $request->folder_id);
            $payload = [
                ...$payload,
                'path' => $replacement->path,
                'file_name' => $replacement->file_name,
                'mime_type' => $replacement->mime_type,
                'size' => $replacement->size,
                'width' => $replacement->width,
                'height' => $replacement->height,
            ];
        }

        $this->media->update($media, $payload);

        return back()->with('success', 'Media updated successfully.');
    }

    public function destroy(MediaFile $media): RedirectResponse
    {
        $this->authorize('delete', $media);

        $this->media->delete($media);

        return back()->with('success', 'Media deleted successfully.');
    }

    public function download(MediaFile $media)
    {
        $this->authorize('view', $media);

        return Storage::disk($media->disk)->download($media->path, $media->file_name);
    }
}
