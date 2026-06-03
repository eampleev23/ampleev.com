<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_read_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('view_article_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('session_key', 80)->unique();
            $table->char('ip', 128);
            $table->text('user_agent')->nullable();
            $table->string('locale', 5)->nullable();
            $table->string('device_type', 20)->nullable();
            $table->string('source_type', 30)->nullable();
            $table->text('referer')->nullable();
            $table->text('first_url')->nullable();
            $table->text('last_url')->nullable();
            $table->unsignedTinyInteger('max_scroll_percent')->default(0);
            $table->boolean('reached_25')->default(false);
            $table->boolean('reached_50')->default(false);
            $table->boolean('reached_75')->default(false);
            $table->boolean('reached_100')->default(false);
            $table->unsignedInteger('active_seconds')->default(0);
            $table->unsignedSmallInteger('viewport_width')->nullable();
            $table->unsignedSmallInteger('viewport_height')->nullable();
            $table->unsignedSmallInteger('screen_width')->nullable();
            $table->unsignedSmallInteger('screen_height')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamps();

            $table->foreign('view_article_id')->references('id')->on('view_articles')->nullOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->index(['article_id', 'created_at'], 'article_read_sessions_article_created_idx');
            $table->index(['article_id', 'max_scroll_percent'], 'article_read_sessions_article_scroll_idx');
            $table->index(['locale', 'created_at'], 'article_read_sessions_locale_created_idx');
            $table->index(['source_type', 'created_at'], 'article_read_sessions_source_created_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_read_sessions');
    }
};
