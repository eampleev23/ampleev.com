<?php

namespace App\Http\Controllers;

use App\OwnerDevice;
use App\Support\OwnerDeviceCookie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;

class OwnerDeviceController extends Controller
{
    public function claim(Request $request)
    {
        $key = (string) $request->query('key');
        abort_unless(Str::isUuid($key), 404);

        $label = trim((string) $request->query('label'));
        if ($label === '') {
            $label = 'owner-device';
        }

        $userAgent = (string) $request->userAgent();
        $agent = new Agent();
        $agent->setUserAgent($userAgent);
        $platformName = $agent->platform();
        $browserName = $agent->browser();

        $device = OwnerDevice::firstOrNew(['key' => $key]);
        $device->fill([
            'label' => mb_substr($label, 0, 120),
            'user_id' => $request->user()?->id,
            'is_active' => true,
            'claimed_at' => $device->claimed_at ?: now(),
            'last_seen_at' => now(),
            'user_agent' => $userAgent ?: null,
            'ip_hash' => $this->hashIp($request->ip()),
            'device_type' => $this->detectDeviceType($agent),
            'platform_name' => $this->limitString($platformName, 100),
            'browser_name' => $this->limitString($browserName, 100),
        ]);
        $device->save();

        $secure = $request->isSecure();

        return redirect()->to('/about_me?owner_device=claimed', 302)
            ->withCookie(cookie(OwnerDeviceCookie::NAME, $device->key, OwnerDeviceCookie::MINUTES, '/', null, $secure, true, false, 'Lax'))
            ->withCookie(cookie('metrika_disabled', '1', 60 * 24 * 365, '/', null, $secure, false, false, 'Lax'));
    }

    private function detectDeviceType(Agent $agent): string
    {
        if ($agent->isTablet()) {
            return 'tablet';
        }

        if ($agent->isMobile()) {
            return 'mobile';
        }

        return 'desktop';
    }

    private function hashIp(?string $ip): ?string
    {
        if (!$ip) {
            return null;
        }

        return hash_hmac('sha256', $ip, (string) config('app.key'));
    }

    private function limitString($value, int $length): ?string
    {
        if (!is_string($value) || $value === '') {
            return null;
        }

        return mb_substr($value, 0, $length);
    }
}
