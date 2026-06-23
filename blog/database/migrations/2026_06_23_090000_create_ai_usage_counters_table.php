<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('ai_usage_snapshots', 'source_id')) {
            Schema::table('ai_usage_snapshots', function (Blueprint $table) {
                $table->string('source_id', 160)
                    ->nullable()
                    ->after('source_host')
                    ->index('ai_usage_snapshots_source_id_idx');
            });
        }

        if (!Schema::hasTable('ai_usage_counters')) {
            Schema::create('ai_usage_counters', function (Blueprint $table) {
                $table->id();
                $table->string('provider', 32);
                $table->string('source_id', 160);
                $table->unsignedBigInteger('raw_total_tokens')->default(0);
                $table->unsignedBigInteger('accumulated_tokens')->default(0);
                $table->unsignedInteger('reset_count')->default(0);
                $table->unsignedBigInteger('last_snapshot_id')->nullable();
                $table->timestamp('last_captured_at')->nullable();
                $table->timestamps();

                $table->unique(['provider', 'source_id'], 'ai_usage_counters_provider_source_unique');
                $table->index(['provider'], 'ai_usage_counters_provider_idx');
                $table->index(['last_captured_at'], 'ai_usage_counters_last_captured_idx');
            });
        }

        if (DB::table('ai_usage_counters')->exists()) {
            return;
        }

        $latestSnapshot = DB::table('ai_usage_snapshots')
            ->orderByDesc('captured_at')
            ->orderByDesc('id')
            ->first();

        if (!$latestSnapshot) {
            return;
        }

        $sourceId = env('AI_USAGE_SOURCE_ID') ?: $latestSnapshot->source_host ?: 'legacy';
        $now = now();

        foreach ([
            'codex' => (int) $latestSnapshot->codex_tokens,
            'claude' => (int) $latestSnapshot->claude_tokens,
        ] as $provider => $tokens) {
            DB::table('ai_usage_counters')->insert([
                'provider' => $provider,
                'source_id' => $sourceId,
                'raw_total_tokens' => $tokens,
                'accumulated_tokens' => $tokens,
                'reset_count' => 0,
                'last_snapshot_id' => $latestSnapshot->id,
                'last_captured_at' => $latestSnapshot->captured_at,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_usage_counters');

        if (Schema::hasColumn('ai_usage_snapshots', 'source_id')) {
            Schema::table('ai_usage_snapshots', function (Blueprint $table) {
                $table->dropColumn('source_id');
            });
        }
    }
};
