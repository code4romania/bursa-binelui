<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['slug', 'value'];

    public static function value(string $slug): ?string
    {
        $key = 'setting.' . $slug;

        return Cache::remember($key, 3600, function () use ($slug) {
            $s = self::query()->where('slug', $slug)->first();

            return $s?->value;
        });
    }

    public static function forgetCache(string $slug): void
    {
        Cache::forget('setting.' . $slug);
    }

    protected static function booted(): void
    {
        static::saved(function (Setting $setting) {
            self::forgetCache($setting->slug);
        });
    }
}
