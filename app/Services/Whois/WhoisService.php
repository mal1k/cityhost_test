<?php
namespace App\Services\Whois;

use Illuminate\Support\Str;
use InvalidArgumentException, RuntimeException;

class WhoisService
{
    public function lookup(string $domain, string $format): mixed
    {
        $raw  = $this->fetchRawWhois($domain);

        return match (strtolower($format)) {
            'json' => $this->jsonParseWhois($raw),
            'raw'  => $raw
        };
    }

    private function fetchRawWhois(string $domain): string
    {
        $tldAscii = idn_to_ascii($domain) ?: throw new InvalidArgumentException("Invalid internationalized domain: {$domain}");
        $tld = strtolower(pathinfo($tldAscii, PATHINFO_EXTENSION));
        $tldServer = TldServerMap::get($tld) ?: throw new RuntimeException("Unknown TLD: ." . idn_to_utf8($tld));
    
        $socket = fsockopen($tldServer, 43, $errorCode, $errorMessage, 15) ?: throw new RuntimeException("Connect to {$tldServer} failed: {$errorMessage} ({$errorCode})");
        fwrite($socket, "$tldAscii\r\n");
        $raw = stream_get_contents($socket);
        fclose($socket);
    
        if (Str::of($raw)->lower()->contains(['no match', 'not found']))
            throw new RuntimeException("Domain {$domain} is not registered");
    
        return $raw;
    }

    private function jsonParseWhois(string $raw): array
    {
        $lines = preg_split("/\r\n|\n|\r/", $raw);
        $section = 'domain';

        foreach ($lines as $line) {
            $line = trim($line);

            if (preg_match('/^%?\s*(Registrar|Registrant|Administrative Contacts|Technical Contacts):/i', $line, $matches)) {
                $section = strtolower(str_replace(' ', '_', $matches[1]));
                continue;
            }

            if (str_starts_with($line, '%') || !str_contains($line, ':'))
                continue;

            [$key, $value] = array_map('trim', explode(':', $line, 2));
            $key = strtolower(str_replace(' ', '_', $key));

            $data[$section] ??= [];
            if (!isset($data[$section][$key])) {
                $data[$section][$key] = $value;
            } else {
                $items = (array) $data[$section][$key];
                if (!in_array($value, $items)) {
                    $items[] = $value;
                    $data[$section][$key] = $items;
                }
            }
        }

        return $data ?? [];
    }
}