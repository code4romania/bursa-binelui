<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class Sanitize
{
    private static function sanitize(?string $input): Stringable
    {
        return Str::of($input)
            ->stripTags()
            ->trim();
    }

    public static function url(?string $link): ?string
    {
        $link = static::sanitize($link)
            ->value();

        return collect(filter_var_array([
            $link,
            "http://{$link}",
        ], \FILTER_VALIDATE_URL))
            ->filter()
            ->first();
    }

    public static function email(?string $email): ?string
    {
        $email = static::sanitize($email)
            ->value();

        if (filter_var($email, \FILTER_VALIDATE_EMAIL)) {
            return $email;
        }

        return null;
    }

    public static function text(?string $text, int | null $limit = null): ?string
    {
        return static::sanitize($text)
            ->when($limit, fn (Stringable $string, int $limit) => $string->limit($limit, ''))
            ->value() ?: null;
    }

    public static function slug(?string $title): ?string
    {
        return static::sanitize($title)
            ->limit(100, '')
            ->slug()
            ->value() ?: null;
    }

    public static function truthy(string | int | null $source): bool
    {
        $attribute = Str::of($source)->slug();

        return $attribute->isNotEmpty() &&
            ! $attribute->contains(['0', 'nu', 'no', 'non']);
    }
}
