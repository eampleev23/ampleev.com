<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddIndexesToViewArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $connection = DB::connection();
        $databaseName = $connection->getDatabaseName();
        
        // Проверяем существование индексов перед добавлением
        $index1Exists = DB::select(
            "SELECT COUNT(*) as count 
             FROM information_schema.statistics 
             WHERE table_schema = ? 
             AND table_name = 'view_articles' 
             AND index_name = 'view_articles_article_user_idx'",
            [$databaseName]
        );
        
        $index2Exists = DB::select(
            "SELECT COUNT(*) as count 
             FROM information_schema.statistics 
             WHERE table_schema = ? 
             AND table_name = 'view_articles' 
             AND index_name = 'view_articles_article_ip_idx'",
            [$databaseName]
        );
        
        $index3Exists = DB::select(
            "SELECT COUNT(*) as count 
             FROM information_schema.statistics 
             WHERE table_schema = ? 
             AND table_name = 'view_articles' 
             AND index_name = 'view_articles_article_ip_user_idx'",
            [$databaseName]
        );
        
        Schema::table('view_articles', function (Blueprint $table) use ($index1Exists, $index2Exists, $index3Exists) {
            // Составной индекс для быстрой проверки просмотров авторизованных пользователей
            if ($index1Exists[0]->count == 0) {
                $table->index(['article_id', 'user_id'], 'view_articles_article_user_idx');
            }
            
            // Составной индекс для быстрой проверки просмотров по IP
            if ($index2Exists[0]->count == 0) {
                $table->index(['article_id', 'ip'], 'view_articles_article_ip_idx');
            }
            
            // Индекс для поиска просмотров по IP без user_id (для миграции неавторизованных просмотров)
            if ($index3Exists[0]->count == 0) {
                $table->index(['article_id', 'ip', 'user_id'], 'view_articles_article_ip_user_idx');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('view_articles', function (Blueprint $table) {
            $table->dropIndex('view_articles_article_user_idx');
            $table->dropIndex('view_articles_article_ip_idx');
            $table->dropIndex('view_articles_article_ip_user_idx');
        });
    }
}

