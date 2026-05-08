<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const ADMIN_NAME = 'admin';
    private const ADMIN_EMAIL = 'admin@ampleev.com';
    private const ADMIN_PASSWORD = 'Newpass34';

    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'is_admin')) {
                $table->boolean('is_admin')->default(false)->after('comment_notifications_enabled');
            }
        });

        $now = now();
        $admin = DB::table('users')
            ->where('name', self::ADMIN_NAME)
            ->orWhere('email', self::ADMIN_EMAIL)
            ->first();

        $payload = [
            'name' => self::ADMIN_NAME,
            'email' => self::ADMIN_EMAIL,
            'email_verified_at' => $now,
            'password' => Hash::make(self::ADMIN_PASSWORD),
            'is_admin' => true,
            'updated_at' => $now,
        ];

        if (Schema::hasColumn('users', 'comment_notifications_enabled')) {
            $payload['comment_notifications_enabled'] = true;
        }

        if ($admin) {
            DB::table('users')
                ->where('id', $admin->id)
                ->update($payload);

            return;
        }

        $payload['created_at'] = $now;

        DB::table('users')->insert($payload);
    }

    public function down(): void
    {
        DB::table('users')
            ->where('name', self::ADMIN_NAME)
            ->where('email', self::ADMIN_EMAIL)
            ->delete();

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_admin')) {
                $table->dropColumn('is_admin');
            }
        });
    }
};
