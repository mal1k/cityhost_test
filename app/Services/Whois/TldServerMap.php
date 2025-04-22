<?php
namespace App\Services\Whois;

use Illuminate\Support\Facades\Storage;

final class TldServerMap
{
    private static ?array $map = null;

    private static function load(): void
    {
        if (!empty(self::$map))
            return;

        $json = Storage::disk('local')->get('tldservers.json');
        self::$map = json_decode($json, true) ?? [];
    }

    public static function get(string $tld): ?string
    {
        self::load();
        return self::$map[strtolower($tld)] ?? null;
    }
}