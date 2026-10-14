<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\MediaFile;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function index(): View
    {
        $mediaFiles = MediaFile::with('uploader')->latest()->paginate(24);

        return view('admin.media.index', compact('mediaFiles'));
    }

    public function store(Request $request, ImageUploadService $imageService): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,webp,svg,gif|max:10240',
            'alt_text_id' => 'nullable|string|max:200',
            'caption' => 'nullable|string|max:255',
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();

        $path = $imageService->processAndStore($file, 'media', 'media');
        $filename = basename($path);

        $media = MediaFile::create([
            'filename' => $filename,
            'original_name' => $originalName,
            'disk' => 'local',
            'path' => $path,
            'mime_type' => $mimeType,
            'file_size' => $fileSize,
            'alt_text_id' => $request->alt_text_id ?: pathinfo($originalName, PATHINFO_FILENAME),
            'caption' => $request->caption,
            'uploaded_by' => auth()->id(),
        ]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'media.uploaded',
            'auditable_type' => MediaFile::class,
            'auditable_id' => $media->id,
            'description' => "Mengunggah media baru: {$originalName}",
        ]);

        return back()->with('success', 'File media berhasil diunggah.');
    }

    public function destroy(MediaFile $media, ImageUploadService $imageService): RedirectResponse
    {
        $imageService->delete($media->path);
        $imageService->delete('uploads/media/'.$media->filename);

        $media->delete();

        return back()->with('success', 'File media berhasil dihapus.');
    }
}
