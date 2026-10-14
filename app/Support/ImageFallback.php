<?php

namespace App\Support;

class ImageFallback
{
    public const DEFAULT_PATH = 'images/default-img.png';

    public static function defaultUrl(): string
    {
        return asset(self::DEFAULT_PATH);
    }

    /**
     * Kembalikan URL gambar yang aman dipakai di <img src> maupun background.
     * - null / string kosong / whitespace -> default-img.png
     * - URL absolut http(s), data:, blob: -> apa adanya
     * - path relatif yang diawali / -> apa adanya (tetap same-origin)
     * - path relatif lain (storage/..., images/...) -> dibungkus asset()
     */
    public static function url(?string $path, ?string $fallback = null): string
    {
        $fallback ??= static::defaultUrl();

        $path = is_string($path) ? trim($path) : '';

        if ($path === '') {
            return $fallback;
        }

        if (
            str_starts_with($path, 'http://') ||
            str_starts_with($path, 'https://') ||
            str_starts_with($path, 'data:') ||
            str_starts_with($path, 'blob:')
        ) {
            return $path;
        }

        if (str_starts_with($path, '/')) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    }
}
