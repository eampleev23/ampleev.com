<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->boolean('show_feedback_questions')->default(false)->after('likes_count');
        });

        DB::table('articles')
            ->where('text_url', 'backlog_refinement_i_ai_chto_realno_menyaetsya')
            ->update(['show_feedback_questions' => true]);
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('show_feedback_questions');
        });
    }
};
