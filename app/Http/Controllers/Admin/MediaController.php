<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\MediaFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function index(): View
    {
        $mediaFiles = MediaFile::with('uploader')->latest()->paginate(24);

        return view('admin.media.index', compact('mediaFiles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,webp,svg,gif|max:5120',
            'alt_text_id' => 'nullable|string|max:200',
            'caption' => 'nullable|string|max:255',
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $filename = 'media_'.date('Ymd_His').'_'.Str::random(8).'.'.$extension;

        $path = $file->storeAs('uploads/media', $filename, 'public');

        $media = MediaFile::create([
            'filename' => $filename,
            'original_name' => $originalName,
            'disk' => 'public',
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
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

    public function destroy(MediaFile $media): RedirectResponse
    {
        if (Storage::disk($media->disk)->exists($media->path)) {
            Storage::disk($media->disk)->delete($media->path);
        }

        $media->delete();

        return back()->with('success', 'File media berhasil dihapus.');
    }
}
