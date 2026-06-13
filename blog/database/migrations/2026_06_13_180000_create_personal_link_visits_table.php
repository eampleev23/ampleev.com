<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_link_visits', function (Blueprint $table) {
            $table->id();
            $table->string('source', 64);
            $table->string('target_path', 255);
            $table->text('target_url');
            $table->string('utm_source', 80);
            $table->string('utm_medium', 40);
            $table->string('utm_campaign', 80);
            $table->string('utm_content', 100);
            $table->text('referer')->nullable();
            $table->text('user_agent')->nullable();
            $table->char('ip_hash', 64)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->index(['source', 'created_at'], 'personal_link_visits_source_created_idx');
            $table->index(['utm_medium', 'created_at'], 'personal_link_visits_medium_created_idx');
            $table->index(['is_admin', 'created_at'], 'personal_link_visits_admin_created_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_link_visits');
    }
};
