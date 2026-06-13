<?php

namespace App\Http\Controllers;

use App\SitePageVisit;
use App\Support\IdentifiesOwnerDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;

class SitePageVisitController extends Controller
{
    use IdentifiesOwnerDevice;

    private const VISITOR_COOKIE = 'site_visitor_id';
    private const SESSION_COOKIE = 'site_session_id';

    public function store(Request $request)
    {
        $validated = $request->validate([
            'page_url' => 'required|string|max:3000',
            'page_title' => 'nullable|string|max:500',
            'canonical_url' => 'nullable|string|max:3000',
            'locale' => 'nullable|string|max:10',
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

        if ($this->shouldSkipUrl((string) $validated['page_url'])) {
            return response()->json(['ok' => false, 'reason' => 'excluded_path']);
        }

        $visitorKey = $this->cookieUuid($request->cookie(self::VISITOR_COOKIE)) ?: (string) Str::uuid();
        $sessionKey = $this->cookieUuid($request->cookie(self::SESSION_COOKIE)) ?: (string) Str::uuid();
        $user = $request->user();
        $pageUrl = (string) $validated['page_url'];
        $referrer = (string) ($validated['referrer'] ?? '');
        $requestReferer = (string) $request->headers->get('referer');
        $userAgent = (string) $request->userAgent();
        $ownerAttributes = $this->ownerTrackingAttributes($request);
        $agent = new Agent();
        $agent->setUserAgent($userAgent);
        $platformName = $agent->platform();
        $browserName = $agent->browser();
        $robotName = $agent->robot();
        $ip = $request->ip();

        $utm = [
            'utm_source' => $this->queryValue($pageUrl, 'utm_source'),
            'utm_medium' => $this->queryValue($pageUrl, 'utm_medium'),
            'utm_campaign' => $this->queryValue($pageUrl, 'utm_campaign'),
            'utm_content' => $this->queryValue($pageUrl, 'utm_content'),
            'utm_term' => $this->queryValue($pageUrl, 'utm_term'),
        ];

        $storedAttribution = $this->decodeAttributionCookie($request->cookie('traffic_attribution'));
        $storedFirstAttribution = $this->decodeAttributionCookie($request->cookie('first_traffic_attribution'));
        $attribution = [
            'source' => $utm['utm_source'] ?: (($storedAttribution['source'] ?? null) ?: $request->cookie('traffic_source')),
            'medium' => $utm['utm_medium'] ?: (($storedAttribution['medium'] ?? null) ?: $request->cookie('traffic_medium')),
            'campaign' => $utm['utm_campaign'] ?: (($storedAttribution['campaign'] ?? null) ?: $request->cookie('traffic_campaign')),
            'content' => $utm['utm_content'] ?: (($storedAttribution['content'] ?? null) ?: $request->cookie('traffic_content')),
        ];
        $firstAttribution = [
            'source' => (($storedFirstAttribution['source'] ?? null) ?: $request->cookie('first_traffic_source')) ?: $attribution['source'],
            'medium' => (($storedFirstAttribution['medium'] ?? null) ?: $request->cookie('first_traffic_medium')) ?: $attribution['medium'],
            'campaign' => (($storedFirstAttribution['campaign'] ?? null) ?: $request->cookie('first_traffic_campaign')) ?: $attribution['campaign'],
            'content' => (($storedFirstAttribution['content'] ?? null) ?: $request->cookie('first_traffic_content')) ?: $attribution['content'],
        ];

        $visit = SitePageVisit::create([
            'event_name' => 'site_page_view',
            'visitor_key' => $visitorKey,
            'session_key' => $sessionKey,
            'page_url' => $pageUrl,
            'page_path' => $this->pathFromUrl($pageUrl),
            'page_query' => $this->queryFromUrl($pageUrl),
            'page_title' => $validated['page_title'] ?? null,
            'canonical_url' => $validated['canonical_url'] ?? null,
            'locale' => $validated['locale'] ?? null,
            'client_referrer' => $referrer ?: null,
            'client_referrer_host' => $this->hostFromUrl($referrer),
            'client_referrer_path' => $this->pathAndQueryFromUrl($referrer),
            'utm_source' => $utm['utm_source'] ?: null,
            'utm_medium' => $utm['utm_medium'] ?: null,
            'utm_campaign' => $utm['utm_campaign'] ?: null,
            'utm_content' => $utm['utm_content'] ?: null,
            'utm_term' => $utm['utm_term'] ?: null,
            'attribution_source' => $attribution['source'] ?: null,
            'attribution_medium' => $attribution['medium'] ?: null,
            'attribution_campaign' => $attribution['campaign'] ?: null,
            'attribution_content' => $attribution['content'] ?: null,
            'first_attribution_source' => $firstAttribution['source'] ?: null,
            'first_attribution_medium' => $firstAttribution['medium'] ?: null,
            'first_attribution_campaign' => $firstAttribution['campaign'] ?: null,
            'first_attribution_content' => $firstAttribution['content'] ?: null,
            'request_host' => $request->getHost(),
            'request_scheme' => $request->getScheme(),
            'request_referer' => $requestReferer ?: null,
            'request_referer_host' => $this->hostFromUrl($requestReferer),
            'request_referer_path' => $this->pathAndQueryFromUrl($requestReferer),
            'user_agent' => $userAgent ?: null,
            'accept_language' => $request->headers->get('accept-language'),
            'primary_language' => $this->primaryLanguage($request->headers->get('accept-language')),
            'sec_ch_ua' => $request->headers->get('sec-ch-ua'),
            'sec_ch_ua_mobile' => $request->headers->get('sec-ch-ua-mobile'),
            'sec_ch_ua_platform' => $request->headers->get('sec-ch-ua-platform'),
            'ip_hash' => $this->hashIp($ip),
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
            'user_id' => $user?->id,
            'is_admin' => (bool) ($user?->is_admin),
            'is_owner' => $ownerAttributes['is_owner'],
            'owner_device_key' => $ownerAttributes['owner_device_key'],
            'owner_device_label' => $ownerAttributes['owner_device_label'],
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
            'server_payload' => $this->serverPayload($request, $pageUrl, $referrer, $utm, $attribution, $agent),
            'client_payload' => $this->jsonPayload($validated),
        ]);

        $response = response()->json([
            'ok' => true,
            'visit_id' => $visit->id,
            'visitor_key' => $visitorKey,
            'session_key' => $sessionKey,
        ]);

        return $this->attachCookies($response, $request, $visitorKey, $sessionKey, $attribution, $firstAttribution);
    }

    private function attachCookies($response, Request $request, string $visitorKey, string $sessionKey, array $attribution, array $firstAttribution)
    {
        $secure = $request->isSecure();
        $response->withCookie(cookie(self::VISITOR_COOKIE, $visitorKey, 60 * 24 * 365, '/', null, $secure, true, false, 'Lax'));
        $response->withCookie(cookie(self::SESSION_COOKIE, $sessionKey, 30, '/', null, $secure, true, false, 'Lax'));

        if ($this->hasAttributionValue($attribution)) {
            $response->withCookie(cookie('traffic_attribution', $this->attributionCookieValue($attribution), 60 * 24 * 180, '/', null, $secure, true, false, 'Lax'));
        }

        if ($this->hasAttributionValue($firstAttribution)) {
            $response->withCookie(cookie('first_traffic_attribution', $this->attributionCookieValue($firstAttribution), 60 * 24 * 180, '/', null, $secure, true, false, 'Lax'));
        }

        return $response;
    }

    private function shouldSkipUrl(string $url): bool
    {
        $path = $this->pathFromUrl($url) ?: '';

        return (bool) preg_match('#^/(admin|drafts|login|profile|confirm_subscriber|confirm-subscriber|en/drafts|en/login|en/profile|en/confirm_subscriber|en/confirm-subscriber)(/|_|-|$)#', $path);
    }

    private function cookieUuid(?string $value): ?string
    {
        return $value && Str::isUuid($value) ? $value : null;
    }

    private function serverPayload(Request $request, string $pageUrl, string $referrer, array $utm, array $attribution, Agent $agent): ?string
    {
        $platformName = $agent->platform();
        $browserName = $agent->browser();
        $robotName = $agent->robot();
        $ip = $request->ip();

        return $this->jsonPayload([
            'event_name' => 'site_page_view',
            'page_url' => $pageUrl,
            'page_path' => $this->pathFromUrl($pageUrl),
            'client_referrer' => $referrer,
            'utm' => $utm,
            'attribution' => $attribution,
            'request' => [
                'method' => $request->method(),
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
                'user_agent' => $request->userAgent(),
                'referer' => $request->headers->get('referer'),
            ],
            'network_estimates' => [
                'ip_hash' => $this->hashIp($ip),
                'forwarded_for_hash' => $this->hashIp($request->headers->get('x-forwarded-for')),
                'real_ip_hash' => $this->hashIp($request->headers->get('x-real-ip')),
                'ip_version' => $this->ipVersion($ip),
                'ip_is_private' => $this->isPrivateIp($ip),
            ],
            'user_agent_estimates' => [
                'device_type' => $this->detectDeviceType($agent),
                'device_name' => $this->limitString($agent->device(), 100),
                'platform_name' => $this->limitString($platformName, 100),
                'platform_version' => $this->limitString($this->agentVersion($agent, $platformName), 60),
                'browser_name' => $this->limitString($browserName, 100),
                'browser_version' => $this->limitString($this->agentVersion($agent, $browserName), 60),
                'is_robot' => (bool) $robotName,
                'robot_name' => $this->limitString($robotName, 100),
                'reliability' => 'estimated_from_user_agent',
            ],
        ]);
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

    private function pathFromUrl(string $url): ?string
    {
        $path = parse_url($url, PHP_URL_PATH);

        return is_string($path) && $path !== '' ? mb_substr($path, 0, 3000) : null;
    }

    private function queryFromUrl(string $url): ?string
    {
        $query = parse_url($url, PHP_URL_QUERY);

        return is_string($query) && $query !== '' ? mb_substr($query, 0, 3000) : null;
    }

    private function queryValue(string $url, string $key): string
    {
        $query = parse_url($url, PHP_URL_QUERY);
        if (!is_string($query) || $query === '') {
            return '';
        }

        parse_str($query, $params);

        return isset($params[$key]) && is_string($params[$key]) ? mb_substr($params[$key], 0, 150) : '';
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

    private function decodeAttributionCookie(?string $value): array
    {
        if (!$value) {
            return [];
        }

        $decoded = json_decode($value, true);
        if (!is_array($decoded)) {
            return [];
        }

        return [
            'source' => $decoded['source'] ?? $decoded['s'] ?? null,
            'medium' => $decoded['medium'] ?? $decoded['m'] ?? null,
            'campaign' => $decoded['campaign'] ?? $decoded['c'] ?? null,
            'content' => $decoded['content'] ?? $decoded['ct'] ?? null,
        ];
    }

    private function attributionCookieValue(array $attribution): string
    {
        return $this->jsonPayload([
            's' => $attribution['source'] ?? '',
            'm' => $attribution['medium'] ?? '',
            'c' => $attribution['campaign'] ?? '',
            'ct' => $attribution['content'] ?? '',
        ]) ?: '{}';
    }

    private function hasAttributionValue(array $attribution): bool
    {
        return (bool) (($attribution['source'] ?? null)
            || ($attribution['medium'] ?? null)
            || ($attribution['campaign'] ?? null)
            || ($attribution['content'] ?? null));
    }
}
