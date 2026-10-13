<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
        'description',
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::rememberForever("setting_{$key}", function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            if (! $setting) {
                return $default;
            }

            if ($setting->type === 'json') {
                return json_decode((string) $setting->value, true) ?: $default;
            }

            if ($setting->type === 'boolean') {
                return filter_var($setting->value, FILTER_VALIDATE_BOOLEAN);
            }

            return $setting->value ?? $default;
        });
    }

    public static function set(string $key, mixed $value, string $group = 'general', string $type = 'text', ?string $description = null): self
    {
        $serializedValue = is_array($value) ? json_encode($value) : (string) $value;

        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'group' => $group,
                'value' => $serializedValue,
                'type' => $type,
                'description' => $description,
            ]
        );

        Cache::forget("setting_{$key}");

        return $setting;
    }
}
