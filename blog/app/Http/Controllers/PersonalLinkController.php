<?php

namespace App\Http\Controllers;

use App\PersonalLinkVisit;
use App\Support\IdentifiesOwnerDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Jenssegers\Agent\Agent;

class PersonalLinkController extends Controller
{
    use IdentifiesOwnerDevice;

    private const VISIT_COOKIE = 'personal_link_visit_id';
    private const PENDING_COOKIE = 'personal_link_visit_pending';

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
        $ownerAttributes = $this->ownerTrackingAttributes($request);
        $serverAttributes = $this->serverAttributes($request, $source, $targetPath, $targetUrl, $utm);

        $visit = PersonalLinkVisit::create(array_merge($serverAttributes, [
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
            'is_owner' => $ownerAttributes['is_owner'],
            'owner_device_key' => $ownerAttributes['owner_device_key'],
            'owner_device_label' => $ownerAttributes['owner_device_label'],
        ]));

        $secure = $request->isSecure();

        return redirect()->to($targetUrl, 302)
            ->withCookie(cookie(self::VISIT_COOKIE, (string) $visit->id, 60 * 24 * 30, '/', null, $secure, true, false, 'Lax'))
            ->withCookie(cookie(self::PENDING_COOKIE, '1', 60, '/', null, $secure, false, false, 'Lax'))
            ->withCookie(cookie('traffic_attribution', $this->attributionCookieValue($utm), 60 * 24 * 180, '/', null, $secure, true, false, 'Lax'))
            ->withCookie(cookie(
                'first_traffic_attribution',
                $request->cookie('first_traffic_attribution') ?: $this->attributionCookieValue($utm),
                60 * 24 * 180,
                '/',
                null,
                $secure,
                true,
                false,
                'Lax'
            ));
    }

    public function enrich(Request $request)
    {
        $visitId = (int) $request->cookie(self::VISIT_COOKIE);
        if (!$visitId) {
            return response()->json(['ok' => false, 'reason' => 'missing_visit_cookie'])
                ->withCookie(cookie()->forget(self::PENDING_COOKIE));
        }

        $validated = $request->validate([
            'page_url' => 'nullable|string|max:3000',
            'referrer' => 'nullable|string|max:3000',
            'timezone' => 'nullable|string|max:100',
            'timezone_offset' => 'nullable|integer|min:-1440|max:1440',
            'language' => 'nullable|string|max:50',
            'languages' => 'nullable|array|max:20',
            'languages.*' => 'nullable|string|max:50',
            'platform' => 'nullable|string|max:100',
            'vendor' => 'nullable|string|max:120',
            'cookie_enabled' => 'nullable|boolean',
            'do_not_track' => 'nullable|string|max:20',
            'screen_width' => 'nullable|integer|min:0|max:20000',
            'screen_height' => 'nullable|integer|min:0|max:20000',
            'available_width' => 'nullable|integer|min:0|max:20000',
            'available_height' => 'nullable|integer|min:0|max:20000',
            'viewport_width' => 'nullable|integer|min:0|max:20000',
            'viewport_height' => 'nullable|integer|min:0|max:20000',
            'device_pixel_ratio' => 'nullable|numeric|min:0|max:20',
            'color_depth' => 'nullable|integer|min:0|max:255',
            'pixel_depth' => 'nullable|integer|min:0|max:255',
            'max_touch_points' => 'nullable|integer|min:0|max:20',
            'hardware_concurrency' => 'nullable|integer|min:0|max:255',
            'device_memory' => 'nullable|numeric|min:0|max:1024',
            'connection_type' => 'nullable|string|max:50',
            'effective_connection_type' => 'nullable|string|max:50',
            'downlink' => 'nullable|numeric|min:0|max:100000',
            'rtt' => 'nullable|integer|min:0|max:100000',
            'save_data' => 'nullable|boolean',
            'touch_supported' => 'nullable|boolean',
            'standalone' => 'nullable|boolean',
            'visibility_state' => 'nullable|string|max:50',
            'local_time' => 'nullable|string|max:120',
            'user_agent_data' => 'nullable|array',
        ]);

        $visit = PersonalLinkVisit::whereKey($visitId)
            ->where('created_at', '>=', now()->subDays(30))
            ->first();

        if (!$visit) {
            return response()->json(['ok' => false, 'reason' => 'visit_not_found'])
                ->withCookie(cookie()->forget(self::PENDING_COOKIE));
        }

        $ownerAttributes = $this->ownerTrackingAttributes($request);
        if ($ownerAttributes['is_owner'] || !$visit->is_owner) {
            $visit->fill($ownerAttributes);
        }

        $visit->fill([
            'client_enriched_at' => now(),
            'client_page_url' => $validated['page_url'] ?? null,
            'client_referrer' => $validated['referrer'] ?? null,
            'client_timezone' => $validated['timezone'] ?? null,
            'client_timezone_offset' => $validated['timezone_offset'] ?? null,
            'client_language' => $validated['language'] ?? null,
            'client_languages' => $this->jsonPayload($validated['languages'] ?? null),
            'client_platform' => $validated['platform'] ?? null,
            'client_vendor' => $validated['vendor'] ?? null,
            'client_cookie_enabled' => $validated['cookie_enabled'] ?? null,
            'client_do_not_track' => $validated['do_not_track'] ?? null,
            'client_screen_width' => $validated['screen_width'] ?? null,
            'client_screen_height' => $validated['screen_height'] ?? null,
            'client_available_width' => $validated['available_width'] ?? null,
            'client_available_height' => $validated['available_height'] ?? null,
            'client_viewport_width' => $validated['viewport_width'] ?? null,
            'client_viewport_height' => $validated['viewport_height'] ?? null,
            'client_device_pixel_ratio' => $validated['device_pixel_ratio'] ?? null,
            'client_color_depth' => $validated['color_depth'] ?? null,
            'client_pixel_depth' => $validated['pixel_depth'] ?? null,
            'client_max_touch_points' => $validated['max_touch_points'] ?? null,
            'client_hardware_concurrency' => $validated['hardware_concurrency'] ?? null,
            'client_device_memory' => $validated['device_memory'] ?? null,
            'client_connection_type' => $validated['connection_type'] ?? null,
            'client_effective_connection_type' => $validated['effective_connection_type'] ?? null,
            'client_downlink' => $validated['downlink'] ?? null,
            'client_rtt' => $validated['rtt'] ?? null,
            'client_save_data' => $validated['save_data'] ?? null,
            'client_touch_supported' => $validated['touch_supported'] ?? null,
            'client_standalone' => $validated['standalone'] ?? null,
            'client_visibility_state' => $validated['visibility_state'] ?? null,
            'client_local_time' => $validated['local_time'] ?? null,
            'client_payload' => $this->jsonPayload($validated),
        ]);
        $visit->save();

        return response()->json([
            'ok' => true,
            'visit_id' => $visit->id,
        ])->withCookie(cookie()->forget(self::PENDING_COOKIE));
    }

    private function serverAttributes(Request $request, string $source, string $targetPath, string $targetUrl, array $utm): array
    {
        $userAgent = (string) $request->userAgent();
        $referer = (string) $request->headers->get('referer');
        $agent = new Agent();
        $agent->setUserAgent($userAgent);
        $platformName = $agent->platform();
        $browserName = $agent->browser();
        $robotName = $agent->robot();
        $ip = $request->ip();

        $attributes = [
            'full_url' => $request->fullUrl(),
            'host' => $request->getHost(),
            'scheme' => $request->getScheme(),
            'referer_host' => $this->hostFromUrl($referer),
            'referer_path' => $this->pathAndQueryFromUrl($referer),
            'accept_language' => $request->headers->get('accept-language'),
            'primary_language' => $this->primaryLanguage($request->headers->get('accept-language')),
            'sec_ch_ua' => $request->headers->get('sec-ch-ua'),
            'sec_ch_ua_mobile' => $request->headers->get('sec-ch-ua-mobile'),
            'sec_ch_ua_platform' => $request->headers->get('sec-ch-ua-platform'),
            'ip_encrypted' => $this->encryptIp($ip),
            'forwarded_for_hash' => $this->hashIp($request->headers->get('x-forwarded-for')),
            'real_ip_hash' => $this->hashIp($request->headers->get('x-real-ip')),
            'ip_version' => $this->ipVersion($ip),
            'ip_is_private' => $this->isPrivateIp($ip),
            'device_type' => $this->detectDeviceType($agent),
            'device_name' => $this->limitString($agent->device(), 100),
            'platform_name' => $this->limitString($platformName, 100),
            'platform_version' => $this->limitString($this->agentVersion($agent, $platformName), 60),
            'browser_name' => $this->limitString($browserName, 100),
            'browser_version' => $this->limitString($this->agentVersion($agent, $browserName), 60),
            'is_robot' => (bool) $robotName,
            'robot_name' => $this->limitString($robotName, 100),
        ];

        $attributes['server_payload'] = $this->jsonPayload([
            'source' => $source,
            'target_path' => $targetPath,
            'target_url' => $targetUrl,
            'utm' => $utm,
            'request' => [
                'method' => $request->method(),
                'full_url' => $request->fullUrl(),
                'host' => $request->getHost(),
                'scheme' => $request->getScheme(),
                'secure' => $request->isSecure(),
            ],
            'safe_headers' => [
                'accept' => $request->headers->get('accept'),
                'accept_language' => $request->headers->get('accept-language'),
                'dnt' => $request->headers->get('dnt'),
                'save_data' => $request->headers->get('save-data'),
                'sec_ch_ua' => $request->headers->get('sec-ch-ua'),
                'sec_ch_ua_mobile' => $request->headers->get('sec-ch-ua-mobile'),
                'sec_ch_ua_platform' => $request->headers->get('sec-ch-ua-platform'),
                'upgrade_insecure_requests' => $request->headers->get('upgrade-insecure-requests'),
                'user_agent' => $userAgent,
                'referer' => $referer,
            ],
            'network_estimates' => [
                'ip_hash' => $this->hashIp($ip),
                'forwarded_for_hash' => $attributes['forwarded_for_hash'],
                'real_ip_hash' => $attributes['real_ip_hash'],
                'ip_version' => $attributes['ip_version'],
                'ip_is_private' => $attributes['ip_is_private'],
            ],
            'user_agent_estimates' => [
                'device_type' => $attributes['device_type'],
                'device_name' => $attributes['device_name'],
                'platform_name' => $attributes['platform_name'],
                'platform_version' => $attributes['platform_version'],
                'browser_name' => $attributes['browser_name'],
                'browser_version' => $attributes['browser_version'],
                'is_robot' => $attributes['is_robot'],
                'robot_name' => $attributes['robot_name'],
                'reliability' => 'estimated_from_user_agent',
            ],
        ]);

        return $attributes;
    }

    private function hashIp(?string $ip): ?string
    {
        if (!$ip) {
            return null;
        }

        return hash_hmac('sha256', $ip, (string) config('app.key'));
    }

    private function encryptIp(?string $ip): ?string
    {
        if (!$ip) {
            return null;
        }

        return Crypt::encryptString($ip);
    }

    private function detectDeviceType(Agent $agent): string
    {
        if ($agent->isRobot()) {
            return 'robot';
        }

        if ($agent->isTablet()) {
            return 'tablet';
        }

        if ($agent->isMobile()) {
            return 'mobile';
        }

        if ($agent->isDesktop()) {
            return 'desktop';
        }

        return 'unknown';
    }

    private function agentVersion(Agent $agent, ?string $name): ?string
    {
        if (!$name) {
            return null;
        }

        $version = $agent->version($name);

        return is_string($version) && $version !== '' ? $version : null;
    }

    private function hostFromUrl(string $url): ?string
    {
        if ($url === '') {
            return null;
        }

        $host = parse_url($url, PHP_URL_HOST);

        return is_string($host) ? mb_strtolower($host) : null;
    }

    private function pathAndQueryFromUrl(string $url): ?string
    {
        if ($url === '') {
            return null;
        }

        $path = parse_url($url, PHP_URL_PATH);
        $query = parse_url($url, PHP_URL_QUERY);
        $value = (is_string($path) ? $path : '');
        if (is_string($query) && $query !== '') {
            $value .= '?' . $query;
        }

        return $value !== '' ? mb_substr($value, 0, 3000) : null;
    }

    private function primaryLanguage(?string $acceptLanguage): ?string
    {
        if (!$acceptLanguage) {
            return null;
        }

        $first = trim(explode(',', $acceptLanguage)[0] ?? '');

        return $first !== '' ? mb_substr($first, 0, 50) : null;
    }

    private function ipVersion(?string $ip): ?string
    {
        if (!$ip) {
            return null;
        }

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return 'IPv4';
        }

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return 'IPv6';
        }

        return null;
    }

    private function isPrivateIp(?string $ip): ?bool
    {
        if (!$ip || !filter_var($ip, FILTER_VALIDATE_IP)) {
            return null;
        }

        return !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
    }

    private function limitString(?string $value, int $limit): ?string
    {
        if (!$value) {
            return null;
        }

        return mb_substr($value, 0, $limit);
    }

    private function jsonPayload($payload): ?string
    {
        if ($payload === null) {
            return null;
        }

        return json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    private function attributionCookieValue(array $utm): string
    {
        return $this->jsonPayload([
            's' => $utm['utm_source'] ?? '',
            'm' => $utm['utm_medium'] ?? '',
            'c' => $utm['utm_campaign'] ?? '',
            'ct' => $utm['utm_content'] ?? '',
        ]) ?: '{}';
    }
}
