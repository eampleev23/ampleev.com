<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('personal_link_visits', function (Blueprint $table) {
            $table->text('full_url')->nullable()->after('target_url');
            $table->string('host')->nullable()->after('full_url');
            $table->string('scheme', 20)->nullable()->after('host');
            $table->string('referer_host')->nullable()->after('referer');
            $table->text('referer_path')->nullable()->after('referer_host');
            $table->text('accept_language')->nullable()->after('user_agent');
            $table->string('primary_language', 50)->nullable()->after('accept_language');
            $table->text('sec_ch_ua')->nullable()->after('primary_language');
            $table->string('sec_ch_ua_mobile', 20)->nullable()->after('sec_ch_ua');
            $table->string('sec_ch_ua_platform', 100)->nullable()->after('sec_ch_ua_mobile');
            $table->text('ip_encrypted')->nullable()->after('ip_hash');
            $table->char('forwarded_for_hash', 64)->nullable()->after('ip_encrypted');
            $table->char('real_ip_hash', 64)->nullable()->after('forwarded_for_hash');
            $table->string('ip_version', 10)->nullable()->after('real_ip_hash');
            $table->boolean('ip_is_private')->nullable()->after('ip_version');
            $table->string('device_type', 30)->nullable()->after('ip_is_private');
            $table->string('device_name', 100)->nullable()->after('device_type');
            $table->string('platform_name', 100)->nullable()->after('device_name');
            $table->string('platform_version', 60)->nullable()->after('platform_name');
            $table->string('browser_name', 100)->nullable()->after('platform_version');
            $table->string('browser_version', 60)->nullable()->after('browser_name');
            $table->boolean('is_robot')->default(false)->after('browser_version');
            $table->string('robot_name', 100)->nullable()->after('is_robot');
            $table->timestamp('client_enriched_at')->nullable()->after('is_admin');
            $table->text('client_page_url')->nullable()->after('client_enriched_at');
            $table->text('client_referrer')->nullable()->after('client_page_url');
            $table->string('client_timezone', 100)->nullable()->after('client_referrer');
            $table->smallInteger('client_timezone_offset')->nullable()->after('client_timezone');
            $table->string('client_language', 50)->nullable()->after('client_timezone_offset');
            $table->text('client_languages')->nullable()->after('client_language');
            $table->string('client_platform', 100)->nullable()->after('client_languages');
            $table->string('client_vendor', 120)->nullable()->after('client_platform');
            $table->boolean('client_cookie_enabled')->nullable()->after('client_vendor');
            $table->string('client_do_not_track', 20)->nullable()->after('client_cookie_enabled');
            $table->unsignedSmallInteger('client_screen_width')->nullable()->after('client_do_not_track');
            $table->unsignedSmallInteger('client_screen_height')->nullable()->after('client_screen_width');
            $table->unsignedSmallInteger('client_available_width')->nullable()->after('client_screen_height');
            $table->unsignedSmallInteger('client_available_height')->nullable()->after('client_available_width');
            $table->unsignedSmallInteger('client_viewport_width')->nullable()->after('client_available_height');
            $table->unsignedSmallInteger('client_viewport_height')->nullable()->after('client_viewport_width');
            $table->decimal('client_device_pixel_ratio', 5, 2)->nullable()->after('client_viewport_height');
            $table->unsignedTinyInteger('client_color_depth')->nullable()->after('client_device_pixel_ratio');
            $table->unsignedTinyInteger('client_pixel_depth')->nullable()->after('client_color_depth');
            $table->unsignedTinyInteger('client_max_touch_points')->nullable()->after('client_pixel_depth');
            $table->unsignedTinyInteger('client_hardware_concurrency')->nullable()->after('client_max_touch_points');
            $table->decimal('client_device_memory', 5, 2)->nullable()->after('client_hardware_concurrency');
            $table->string('client_connection_type', 50)->nullable()->after('client_device_memory');
            $table->string('client_effective_connection_type', 50)->nullable()->after('client_connection_type');
            $table->decimal('client_downlink', 6, 2)->nullable()->after('client_effective_connection_type');
            $table->unsignedInteger('client_rtt')->nullable()->after('client_downlink');
            $table->boolean('client_save_data')->nullable()->after('client_rtt');
            $table->boolean('client_touch_supported')->nullable()->after('client_save_data');
            $table->boolean('client_standalone')->nullable()->after('client_touch_supported');
            $table->string('client_visibility_state', 50)->nullable()->after('client_standalone');
            $table->string('client_local_time', 120)->nullable()->after('client_visibility_state');
            $table->longText('server_payload')->nullable()->after('client_local_time');
            $table->longText('client_payload')->nullable()->after('server_payload');

            $table->index(['device_type', 'created_at'], 'personal_link_visits_device_created_idx');
            $table->index(['browser_name', 'created_at'], 'personal_link_visits_browser_created_idx');
            $table->index(['primary_language', 'created_at'], 'personal_link_visits_language_created_idx');
            $table->index(['client_enriched_at'], 'personal_link_visits_client_enriched_idx');
        });
    }

    public function down(): void
    {
        Schema::table('personal_link_visits', function (Blueprint $table) {
            $table->dropIndex('personal_link_visits_device_created_idx');
            $table->dropIndex('personal_link_visits_browser_created_idx');
            $table->dropIndex('personal_link_visits_language_created_idx');
            $table->dropIndex('personal_link_visits_client_enriched_idx');

            $table->dropColumn([
                'full_url',
                'host',
                'scheme',
                'referer_host',
                'referer_path',
                'accept_language',
                'primary_language',
                'sec_ch_ua',
                'sec_ch_ua_mobile',
                'sec_ch_ua_platform',
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
            ]);
        });
    }
};
