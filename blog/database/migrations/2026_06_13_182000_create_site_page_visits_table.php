<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_page_visits', function (Blueprint $table) {
            $table->id();
            $table->string('event_name', 50)->default('site_page_view');
            $table->char('visitor_key', 36)->nullable();
            $table->char('session_key', 36)->nullable();
            $table->text('page_url');
            $table->text('page_path')->nullable();
            $table->text('page_query')->nullable();
            $table->string('page_title', 500)->nullable();
            $table->text('canonical_url')->nullable();
            $table->string('locale', 10)->nullable();
            $table->text('client_referrer')->nullable();
            $table->string('client_referrer_host')->nullable();
            $table->text('client_referrer_path')->nullable();
            $table->string('utm_source', 100)->nullable();
            $table->string('utm_medium', 80)->nullable();
            $table->string('utm_campaign', 120)->nullable();
            $table->string('utm_content', 150)->nullable();
            $table->string('utm_term', 150)->nullable();
            $table->string('attribution_source', 100)->nullable();
            $table->string('attribution_medium', 80)->nullable();
            $table->string('attribution_campaign', 120)->nullable();
            $table->string('attribution_content', 150)->nullable();
            $table->string('first_attribution_source', 100)->nullable();
            $table->string('first_attribution_medium', 80)->nullable();
            $table->string('first_attribution_campaign', 120)->nullable();
            $table->string('first_attribution_content', 150)->nullable();
            $table->string('request_host')->nullable();
            $table->string('request_scheme', 20)->nullable();
            $table->text('request_referer')->nullable();
            $table->string('request_referer_host')->nullable();
            $table->text('request_referer_path')->nullable();
            $table->text('user_agent')->nullable();
            $table->text('accept_language')->nullable();
            $table->string('primary_language', 50)->nullable();
            $table->text('sec_ch_ua')->nullable();
            $table->string('sec_ch_ua_mobile', 20)->nullable();
            $table->string('sec_ch_ua_platform', 100)->nullable();
            $table->char('ip_hash', 64)->nullable();
            $table->text('ip_encrypted')->nullable();
            $table->char('forwarded_for_hash', 64)->nullable();
            $table->char('real_ip_hash', 64)->nullable();
            $table->string('ip_version', 10)->nullable();
            $table->boolean('ip_is_private')->nullable();
            $table->string('device_type', 30)->nullable();
            $table->string('device_name', 100)->nullable();
            $table->string('platform_name', 100)->nullable();
            $table->string('platform_version', 60)->nullable();
            $table->string('browser_name', 100)->nullable();
            $table->string('browser_version', 60)->nullable();
            $table->boolean('is_robot')->default(false);
            $table->string('robot_name', 100)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->string('client_timezone', 100)->nullable();
            $table->smallInteger('client_timezone_offset')->nullable();
            $table->string('client_language', 50)->nullable();
            $table->text('client_languages')->nullable();
            $table->string('client_platform', 100)->nullable();
            $table->string('client_vendor', 120)->nullable();
            $table->boolean('client_cookie_enabled')->nullable();
            $table->string('client_do_not_track', 20)->nullable();
            $table->unsignedSmallInteger('client_screen_width')->nullable();
            $table->unsignedSmallInteger('client_screen_height')->nullable();
            $table->unsignedSmallInteger('client_available_width')->nullable();
            $table->unsignedSmallInteger('client_available_height')->nullable();
            $table->unsignedSmallInteger('client_viewport_width')->nullable();
            $table->unsignedSmallInteger('client_viewport_height')->nullable();
            $table->decimal('client_device_pixel_ratio', 5, 2)->nullable();
            $table->unsignedTinyInteger('client_color_depth')->nullable();
            $table->unsignedTinyInteger('client_pixel_depth')->nullable();
            $table->unsignedTinyInteger('client_max_touch_points')->nullable();
            $table->unsignedTinyInteger('client_hardware_concurrency')->nullable();
            $table->decimal('client_device_memory', 5, 2)->nullable();
            $table->string('client_connection_type', 50)->nullable();
            $table->string('client_effective_connection_type', 50)->nullable();
            $table->decimal('client_downlink', 6, 2)->nullable();
            $table->unsignedInteger('client_rtt')->nullable();
            $table->boolean('client_save_data')->nullable();
            $table->boolean('client_touch_supported')->nullable();
            $table->boolean('client_standalone')->nullable();
            $table->string('client_visibility_state', 50)->nullable();
            $table->string('client_local_time', 120)->nullable();
            $table->longText('server_payload')->nullable();
            $table->longText('client_payload')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->index(['created_at'], 'site_page_visits_created_idx');
            $table->index(['visitor_key', 'created_at'], 'site_page_visits_visitor_created_idx');
            $table->index(['session_key', 'created_at'], 'site_page_visits_session_created_idx');
            $table->index(['utm_source', 'created_at'], 'site_page_visits_utm_source_created_idx');
            $table->index(['attribution_source', 'created_at'], 'site_page_visits_attr_source_created_idx');
            $table->index(['device_type', 'created_at'], 'site_page_visits_device_created_idx');
            $table->index(['browser_name', 'created_at'], 'site_page_visits_browser_created_idx');
            $table->index(['is_admin', 'created_at'], 'site_page_visits_admin_created_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_page_visits');
    }
};
