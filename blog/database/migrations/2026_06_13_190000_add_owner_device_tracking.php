<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('owner_devices', function (Blueprint $table) {
            $table->id();
            $table->char('key', 36)->unique();
            $table->string('label', 120);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('claimed_at')->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->text('user_agent')->nullable();
            $table->char('ip_hash', 64)->nullable();
            $table->string('device_type', 30)->nullable();
            $table->string('platform_name', 100)->nullable();
            $table->string('browser_name', 100)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->index(['is_active', 'last_seen_at'], 'owner_devices_active_seen_idx');
        });

        foreach ($this->trackedTables() as $tableName => $indexPrefix) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->boolean('is_owner')->default(false);
                $table->char('owner_device_key', 36)->nullable();
                $table->string('owner_device_label', 120)->nullable();
                $table->index(['is_owner', 'created_at'], $table->getTable() . '_owner_created_idx');
                $table->index(['owner_device_key', 'created_at'], $table->getTable() . '_owner_device_created_idx');
            });
        }
    }

    public function down(): void
    {
        foreach ($this->trackedTables() as $tableName => $indexPrefix) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropIndex($table->getTable() . '_owner_created_idx');
                $table->dropIndex($table->getTable() . '_owner_device_created_idx');
                $table->dropColumn(['is_owner', 'owner_device_key', 'owner_device_label']);
            });
        }

        Schema::dropIfExists('owner_devices');
    }

    private function trackedTables(): array
    {
        return [
            'personal_link_visits' => 'personal_link_visits',
            'site_page_visits' => 'site_page_visits',
            'article_read_sessions' => 'article_read_sessions',
            'article_feedback_answers' => 'article_feedback_answers',
            'view_articles' => 'view_articles',
        ];
    }
};
