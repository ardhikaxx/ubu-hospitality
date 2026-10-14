<?php

use App\Support\ImageFallback;

if (! function_exists('image_or_default')) {
    function image_or_default(?string $path, ?string $fallback = null): string
    {
        return ImageFallback::url($path, $fallback);
    }
}

if (! function_exists('default_image_url')) {
    function default_image_url(): string
    {
        return ImageFallback::defaultUrl();
    }
}
