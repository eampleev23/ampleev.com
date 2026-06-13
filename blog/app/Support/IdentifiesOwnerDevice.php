<?php

namespace App\Support;

use App\OwnerDevice;
use Illuminate\Http\Request;
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

        if (!is_string($key) || !Str::isUuid($key)) {
            return null;
        }

        return OwnerDevice::where('key', $key)
            ->where('is_active', true)
            ->first();
    }
}
