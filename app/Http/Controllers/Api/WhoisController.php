<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WhoisRequest;
use App\Services\Whois\WhoisService;

class WhoisController extends Controller
{
    public function __invoke(WhoisRequest $request, WhoisService $service)
    {
        $domain = $request->validated('domain');
        $format = $request->validated('format');

        try {
            $whois = $service->lookup($domain, $format);

            return response()->json([
                'domain'  => $request->domain,
                'whois'   => $whois,
            ]);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}