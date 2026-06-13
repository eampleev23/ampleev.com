<?php

namespace App\Support;

final class OwnerDeviceCookie
{
    public const NAME = 'owner_device_key';
    public const MINUTES = 60 * 24 * 365 * 5;

    private function __construct()
    {
    }
}
