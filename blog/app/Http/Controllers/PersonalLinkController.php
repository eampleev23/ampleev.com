<?php

namespace App\Http\Controllers;

use App\PersonalLinkVisit;
use Illuminate\Http\Request;

class PersonalLinkController extends Controller
{
    public function show(Request $request, string $source)
    {
        $source = strtolower($source);
        $targetPath = '/about_me';
        $utm = [
            'utm_source' => $source,
            'utm_medium' => 'shortlink',
            'utm_campaign' => 'personal_profile',
            'utm_content' => 'me_' . $source,
        ];
        $targetUrl = $targetPath . '?' . http_build_query($utm, '', '&', PHP_QUERY_RFC3986);
        $user = $request->user();

        PersonalLinkVisit::create([
            'source' => $source,
            'target_path' => $targetPath,
            'target_url' => $targetUrl,
            'utm_source' => $utm['utm_source'],
            'utm_medium' => $utm['utm_medium'],
            'utm_campaign' => $utm['utm_campaign'],
            'utm_content' => $utm['utm_content'],
            'referer' => $request->headers->get('referer'),
            'user_agent' => $request->userAgent(),
            'ip_hash' => $this->hashIp($request->ip()),
            'user_id' => $user?->id,
            'is_admin' => (bool) ($user?->is_admin),
        ]);

        return redirect()->to($targetUrl, 302);
    }

    private function hashIp(?string $ip): ?string
    {
        if (!$ip) {
            return null;
        }

        return hash_hmac('sha256', $ip, (string) config('app.key'));
    }
}
