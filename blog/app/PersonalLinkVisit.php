<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalLinkVisit extends Model
{
    protected $fillable = [
        'source',
        'target_path',
        'target_url',
        'full_url',
        'host',
        'scheme',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_content',
        'referer',
        'referer_host',
        'referer_path',
        'user_agent',
        'accept_language',
        'primary_language',
        'sec_ch_ua',
        'sec_ch_ua_mobile',
        'sec_ch_ua_platform',
        'ip_hash',
        'ip_encrypted',
        'forwarded_for_hash',
        'real_ip_hash',
        'ip_version',
        'ip_is_private',
        'device_type',
        'device_name',
        'platform_name',
        'platform_version',
        'browser_name',
        'browser_version',
        'is_robot',
        'robot_name',
        'user_id',
        'is_admin',
        'client_enriched_at',
        'client_page_url',
        'client_referrer',
        'client_timezone',
        'client_timezone_offset',
        'client_language',
        'client_languages',
        'client_platform',
        'client_vendor',
        'client_cookie_enabled',
        'client_do_not_track',
        'client_screen_width',
        'client_screen_height',
        'client_available_width',
        'client_available_height',
        'client_viewport_width',
        'client_viewport_height',
        'client_device_pixel_ratio',
        'client_color_depth',
        'client_pixel_depth',
        'client_max_touch_points',
        'client_hardware_concurrency',
        'client_device_memory',
        'client_connection_type',
        'client_effective_connection_type',
        'client_downlink',
        'client_rtt',
        'client_save_data',
        'client_touch_supported',
        'client_standalone',
        'client_visibility_state',
        'client_local_time',
        'server_payload',
        'client_payload',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
        'ip_is_private' => 'boolean',
        'is_robot' => 'boolean',
        'client_enriched_at' => 'datetime',
        'client_cookie_enabled' => 'boolean',
        'client_save_data' => 'boolean',
        'client_touch_supported' => 'boolean',
        'client_standalone' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
