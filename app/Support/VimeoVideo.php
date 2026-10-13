<?php

namespace App\Support;

class VimeoVideo
{
    /**
     * Store as Vimeo numeric id, or id:hash when a privacy hash is present.
     */
    public static function normalize(?string $value): ?string
    {
        $parsed = self::parse($value);

        if (! $parsed) {
            return null;
        }

        return $parsed['hash']
            ? $parsed['id'].':'.$parsed['hash']
            : $parsed['id'];
    }

    public static function hasVideo(?string $value): bool
    {
        return self::parse($value) !== null;
    }

    public static function embedUrl(?string $value): ?string
    {
        $parsed = self::parse($value);

        if (! $parsed) {
            return null;
        }

        $query = [
            'title' => 0,
            'byline' => 0,
            'portrait' => 0,
            'dnt' => 1,
        ];

        if ($parsed['hash']) {
            $query['h'] = $parsed['hash'];
        }

        return 'https://player.vimeo.com/video/'.$parsed['id'].'?'.http_build_query($query);
    }

    /**
     * @return array{id: string, hash: ?string}|null
     */
    public static function parse(?string $value): ?array
    {
        $value = trim(html_entity_decode((string) $value));

        if ($value === '') {
            return null;
        }

        if (preg_match('/src=["\']([^"\']+)["\']/', $value, $iframe)) {
            $value = trim($iframe[1]);
        }

        if (preg_match('/^(\d{5,12})(?::([a-zA-Z0-9]+))?$/', $value, $m)) {
            return ['id' => $m[1], 'hash' => $m[2] ?? null];
        }

        if (! preg_match('#vimeo\.com#i', $value)) {
            return null;
        }

        $hash = null;
        if (preg_match('/[?&]h=([a-zA-Z0-9]+)/', $value, $h)) {
            $hash = $h[1];
        }

        if (preg_match('#(?:player\.)?vimeo\.com/(?:video/)?(\d{5,12})(?:/([a-zA-Z0-9]+))?#i', $value, $m)) {
            if (! $hash && ! empty($m[2]) && ! in_array(strtolower($m[2]), ['video'], true)) {
                $hash = $m[2];
            }

            return ['id' => $m[1], 'hash' => $hash];
        }

        return null;
    }
}
