<?php

namespace App\Support;

use App\OwnerDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait IdentifiesOwnerDevice
{
    protected function ownerTrackingAttributes(Request $request): array
    {
        $user = $request->user();
        $device = $this->ownerDeviceFromRequest($request);
        $isAdmin = (bool) ($user?->is_admin);
        $isOwner = (bool) $device || $isAdmin;

        if ($device) {
            $device->forceFill(['last_seen_at' => now()])->save();
        }

        return [
            'is_owner' => $isOwner,
            'owner_device_key' => $device?->key,
            'owner_device_label' => $device?->label ?: ($isAdmin ? 'admin_session' : null),
        ];
    }

    protected function ownerDeviceFromRequest(Request $request): ?OwnerDevice
    {
        $key = $request->cookie(OwnerDeviceCookie::NAME);

        if (is_string($key) && Str::isUuid($key)) {
            $device = OwnerDevice::where('key', $key)
                ->where('is_active', true)
                ->first();

            if ($device) {
                return $device;
            }
        }

        $device = $this->ownerDeviceFromKnownVisitCookie($request);
        if ($device) {
            return $device;
        }

        $ipHash = $this->ownerDeviceIpHash($request->ip());
        if (!$ipHash) {
            return null;
        }

        return OwnerDevice::where('ip_hash', $ipHash)
            ->where('is_active', true)
            ->orderByDesc('last_seen_at')
            ->orderByDesc('id')
            ->first();
    }

    private function ownerDeviceFromKnownVisitCookie(Request $request): ?OwnerDevice
    {
        $visitorKey = $request->cookie('site_visitor_id');
        $sessionKey = $request->cookie('site_session_id');

        $hasVisitorKey = is_string($visitorKey) && Str::isUuid($visitorKey);
        $hasSessionKey = is_string($sessionKey) && Str::isUuid($sessionKey);

        if (!$hasVisitorKey && !$hasSessionKey) {
            return null;
        }

        $ownerVisit = DB::table('site_page_visits')
            ->where('is_owner', true)
            ->whereNotNull('owner_device_key')
            ->where(function ($query) use ($visitorKey, $sessionKey, $hasVisitorKey, $hasSessionKey) {
                if ($hasVisitorKey) {
                    $query->where('visitor_key', $visitorKey);
                }

                if ($hasSessionKey) {
                    $method = $hasVisitorKey ? 'orWhere' : 'where';
                    $query->{$method}('session_key', $sessionKey);
                }
            })
            ->latest('id')
            ->first();

        if (!$ownerVisit?->owner_device_key) {
            return null;
        }

        return OwnerDevice::where('key', $ownerVisit->owner_device_key)
            ->where('is_active', true)
            ->first();
    }

    private function ownerDeviceIpHash(?string $ip): ?string
    {
        if (!$ip) {
            return null;
        }

        return hash_hmac('sha256', $ip, (string) config('app.key'));
    }
}
