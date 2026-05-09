<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mailings', function (Blueprint $table) {
            if (!Schema::hasColumn('mailings', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('confirmed');
                $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            }

            if (!Schema::hasColumn('mailings', 'ip')) {
                $table->char('ip', 128)->nullable()->after('user_id');
            }

            if (!Schema::hasColumn('mailings', 'user_agent')) {
                $table->text('user_agent')->nullable()->after('ip');
            }

            if (!Schema::hasColumn('mailings', 'locale')) {
                $table->string('locale', 5)->nullable()->after('user_agent');
            }

            if (!Schema::hasColumn('mailings', 'referer')) {
                $table->text('referer')->nullable()->after('locale');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mailings', function (Blueprint $table) {
            if (Schema::hasColumn('mailings', 'user_id')) {
                $table->dropForeign(['user_id']);
            }

            $columns = array_filter([
                Schema::hasColumn('mailings', 'referer') ? 'referer' : null,
                Schema::hasColumn('mailings', 'locale') ? 'locale' : null,
                Schema::hasColumn('mailings', 'user_agent') ? 'user_agent' : null,
                Schema::hasColumn('mailings', 'ip') ? 'ip' : null,
                Schema::hasColumn('mailings', 'user_id') ? 'user_id' : null,
            ]);

            if ($columns) {
                $table->dropColumn($columns);
            }
        });
    }
};
