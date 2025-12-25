<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // zoom = как сейчас (кликабельно, fancybox); static = без увеличения
            $table->string('main_image_mode', 20)->default('zoom')->after('main_image_path');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('main_image_mode');
        });
    }
};


