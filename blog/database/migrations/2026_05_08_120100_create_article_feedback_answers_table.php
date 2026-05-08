<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_feedback_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->string('question_key', 50);
            $table->string('answer', 10);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->char('ip', 128);
            $table->text('user_agent')->nullable();
            $table->string('locale', 5)->nullable();
            $table->text('referer')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->index(['article_id', 'question_key', 'user_id'], 'article_feedback_article_question_user_idx');
            $table->index(['article_id', 'question_key', 'ip'], 'article_feedback_article_question_ip_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_feedback_answers');
    }
};
