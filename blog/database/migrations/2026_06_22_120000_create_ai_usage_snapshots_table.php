<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_usage_snapshots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('total_tokens')->default(0);
            $table->unsignedBigInteger('claude_tokens')->default(0);
            $table->unsignedBigInteger('codex_tokens')->default(0);
            $table->timestamp('captured_at')->nullable();
            $table->string('source_host', 120)->nullable();
            $table->char('payload_hash', 64)->nullable();
            $table->json('provider_payload')->nullable();
            $table->timestamps();

            $table->index(['captured_at'], 'ai_usage_snapshots_captured_idx');
            $table->unique('payload_hash', 'ai_usage_snapshots_payload_hash_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_usage_snapshots');
    }
};
