<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->string('locale', 5);
            $table->string('text_url')->nullable();
            $table->string('title')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('html_title')->nullable();
            $table->longText('first_paragraph')->nullable();
            $table->longText('content')->nullable();
            $table->string('main_image_path')->nullable();
            $table->string('hero_image_path')->nullable();
            $table->string('article_layout', 50)->nullable();
            $table->timestamps();

            $table->unique(['article_id', 'locale']);
            $table->unique(['locale', 'text_url']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_translations');
    }
};
