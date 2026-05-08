<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('article_feedback_answers', function (Blueprint $table) {
            $table->unsignedBigInteger('view_article_id')->nullable()->after('user_id');
            $table->foreign('view_article_id')
                ->references('id')
                ->on('view_articles')
                ->nullOnDelete();
            $table->index('view_article_id', 'article_feedback_view_article_idx');
        });
    }

    public function down(): void
    {
        Schema::table('article_feedback_answers', function (Blueprint $table) {
            $table->dropForeign(['view_article_id']);
            $table->dropIndex('article_feedback_view_article_idx');
            $table->dropColumn('view_article_id');
        });
    }
};
