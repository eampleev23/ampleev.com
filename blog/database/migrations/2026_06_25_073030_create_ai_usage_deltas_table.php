<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_usage_deltas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('snapshot_id')->nullable();
            $table->string('provider', 32);
            $table->string('source_id', 160);
            $table->unsignedBigInteger('previous_raw_total_tokens')->nullable();
            $table->unsignedBigInteger('raw_total_tokens')->default(0);
            $table->unsignedBigInteger('delta_tokens')->default(0);
            $table->unsignedBigInteger('accumulated_tokens')->default(0);
            $table->boolean('reset_detected')->default(false);
            $table->boolean('correction_detected')->default(false);
            $table->timestamp('captured_at')->nullable();
            $table->timestamps();

            $table->index(['captured_at'], 'ai_usage_deltas_captured_idx');
            $table->index(['provider', 'captured_at'], 'ai_usage_deltas_provider_captured_idx');
            $table->index(['source_id', 'captured_at'], 'ai_usage_deltas_source_captured_idx');
            $table->unique(['snapshot_id', 'provider', 'source_id'], 'ai_usage_deltas_snapshot_provider_source_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_usage_deltas');
    }
};
