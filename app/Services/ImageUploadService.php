<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageUploadService
{
    /**
     * Upload and process an image (with optional WebP conversion and resizing).
     * Saves file to both public_path and storage_path without requiring storage:link.
     */
    public function processAndStore(
        UploadedFile $file,
        string $folder = 'general',
        ?string $prefix = null,
        int $maxWidth = 1400,
        int $quality = 82
    ): string {
        $cleanFolder = trim(str_replace(['\\', '..'], ['/', ''], $folder), '/');
        $prefix = $prefix ?: $cleanFolder;
        $extension = strtolower($file->getClientOriginalExtension());
        $mime = $file->getMimeType();

        $storageDir = storage_path("uploads/{$cleanFolder}");
        $publicDir = public_path("uploads/{$cleanFolder}");

        if (! File::isDirectory($storageDir)) {
            File::makeDirectory($storageDir, 0755, true, true);
        }
        if (! File::isDirectory($publicDir)) {
            File::makeDirectory($publicDir, 0755, true, true);
        }

        // For SVG or files where GD is not applicable, save directly
        if ($extension === 'svg' || $mime === 'image/svg+xml') {
            $filename = "{$prefix}_".time().'_'.Str::random(8).'.svg';
            $file->move($publicDir, $filename);
            File::copy("{$publicDir}/{$filename}", "{$storageDir}/{$filename}");

            return "uploads/{$cleanFolder}/{$filename}";
        }

        $pathname = $file->getPathname();
        $imageInfo = @getimagesize($pathname);

        $source = null;
        if ($imageInfo) {
            $source = match ($imageInfo['mime']) {
                'image/jpeg' => @imagecreatefromjpeg($pathname),
                'image/png' => @imagecreatefrompng($pathname),
                'image/webp' => @imagecreatefromwebp($pathname),
                'image/gif' => @imagecreatefromgif($pathname),
                default => null,
            };
        }

        // Fallback: move file directly if GD can't process it
        if (! $source || ! $imageInfo) {
            $filename = "{$prefix}_".time().'_'.Str::random(8).'.'.$extension;
            $file->move($publicDir, $filename);
            File::copy("{$publicDir}/{$filename}", "{$storageDir}/{$filename}");

            return "uploads/{$cleanFolder}/{$filename}";
        }

        [$origWidth, $origHeight] = $imageInfo;

        if ($origWidth <= $maxWidth) {
            $newWidth = $origWidth;
            $newHeight = $origHeight;
        } else {
            $ratio = $maxWidth / $origWidth;
            $newWidth = $maxWidth;
            $newHeight = (int) round($origHeight * $ratio);
        }

        $resized = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve alpha transparency for PNG / WebP / GIF
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        $transparent = imagecolorallocatealpha($resized, 255, 255, 255, 127);
        imagefilledrectangle($resized, 0, 0, $newWidth, $newHeight, $transparent);

        imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        $filename = "{$prefix}_".time().'_'.Str::random(8).'.webp';
        $publicDestination = "{$publicDir}/{$filename}";
        $storageDestination = "{$storageDir}/{$filename}";

        // Save as WebP
        imagewebp($resized, $publicDestination, $quality);
        File::copy($publicDestination, $storageDestination);

        imagedestroy($source);
        imagedestroy($resized);

        return "uploads/{$cleanFolder}/{$filename}";
    }

    /**
     * Replace an existing image with a new upload and remove old file.
     */
    public function replace(
        UploadedFile $newFile,
        ?string $oldPath,
        string $folder = 'general',
        ?string $prefix = null,
        int $maxWidth = 1400,
        int $quality = 82
    ): string {
        $newPath = $this->processAndStore($newFile, $folder, $prefix, $maxWidth, $quality);

        if (! empty($oldPath)) {
            $this->delete($oldPath);
        }

        return $newPath;
    }

    /**
     * Safely delete an uploaded file from disk (both public and storage paths).
     */
    public function delete(?string $path): bool
    {
        if (empty($path)) {
            return false;
        }

        $clean = ltrim(str_replace(['\\', '..'], ['/', ''], $path), '/');

        // Only allow deleting files inside uploads/ directory for security
        if (! str_starts_with($clean, 'uploads/')) {
            if (str_starts_with($clean, 'storage/uploads/')) {
                $clean = substr($clean, strlen('storage/'));
            } else {
                return false;
            }
        }

        $deleted = false;
        $publicFile = public_path($clean);
        $storageFile = storage_path($clean);

        if (File::exists($publicFile)) {
            File::delete($publicFile);
            $deleted = true;
        }

        if (File::exists($storageFile)) {
            File::delete($storageFile);
            $deleted = true;
        }

        return $deleted;
    }
}
