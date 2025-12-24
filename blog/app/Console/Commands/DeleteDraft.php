<?php

namespace App\Console\Commands;

use App\Article;
use App\Comment;
use App\ViewArticle;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class DeleteDraft extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:draft {text_url : text_url черновика для удаления}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удаляет черновик статьи (файл и запись из БД)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $textUrl = $this->argument('text_url');
        $filename = $textUrl . '.html';
        $draftPath = storage_path('drafts/' . $filename);

        // Проверяем существование файла
        $fileExists = File::exists($draftPath);
        
        // Ищем статью в БД
        $article = Article::where('text_url', $textUrl)->first();

        // Если статья опубликована - запрещаем удаление
        if ($article && $article->confirmed == 1) {
            $this->error("Нельзя удалить опубликованную статью (confirmed = 1)!");
            $this->info("Статья: {$article->title}");
            $this->info("URL: http://localhost:8000/article_{$textUrl}");
            return 1;
        }

        // Показываем информацию о том, что будет удалено
        $this->info("Черновик для удаления: {$textUrl}");
        
        if ($article) {
            $this->info("Найдена запись в БД:");
            $this->line("  - ID: {$article->id}");
            $this->line("  - Название: {$article->title}");
            $this->line("  - Статус: " . ($article->confirmed == 1 ? 'Опубликовано' : 'Черновик'));
            
            $commentsCount = $article->comments()->count();
            $viewsCount = $article->viewsArticles()->count();
            
            if ($commentsCount > 0) {
                $this->warn("  - Комментариев: {$commentsCount} (будут удалены)");
            }
            
            if ($viewsCount > 0) {
                $this->warn("  - Записей о просмотрах: {$viewsCount} (будут удалены)");
            }
        } else {
            $this->warn("Запись в БД не найдена (будет удален только файл)");
        }
        
        if ($fileExists) {
            $this->info("Найден файл: {$filename}");
        } else {
            $this->warn("Файл не найден: {$filename}");
        }

        // Запрашиваем подтверждение
        if (!$this->confirm('Вы уверены, что хотите удалить этот черновик?', true)) {
            $this->info('Удаление отменено.');
            return 0;
        }

        // Выполняем удаление в транзакции
        try {
            return DB::transaction(function () use ($article, $draftPath, $fileExists, $textUrl) {
                $deletedFile = false;
                $deletedDb = false;
                $deletedComments = 0;
                $deletedViews = 0;

                // Удаляем файл
                if ($fileExists) {
                    if (File::delete($draftPath)) {
                        $deletedFile = true;
                        $this->info("✓ Файл удален: {$draftPath}");
                    } else {
                        throw new \Exception("Не удалось удалить файл: {$draftPath}");
                    }
                }

                // Удаляем запись из БД и связанные данные
                if ($article) {
                    $articleId = $article->id;
                    
                    // Удаляем комментарии
                    $deletedComments = $article->comments()->count();
                    $article->comments()->delete();
                    
                    // Удаляем записи о просмотрах
                    $deletedViews = $article->viewsArticles()->count();
                    $article->viewsArticles()->delete();
                    
                    // Удаляем саму статью
                    $article->delete();
                    $deletedDb = true;
                    $this->info("✓ Запись в БД удалена (ID: {$articleId})");
                    
                    if ($deletedComments > 0) {
                        $this->info("✓ Удалено комментариев: {$deletedComments}");
                    }
                    
                    if ($deletedViews > 0) {
                        $this->info("✓ Удалено записей о просмотрах: {$deletedViews}");
                    }
                }

                // Формируем итоговый отчет
                $this->newLine();
                $this->info("=== Итоговый отчет ===");
                
                if ($deletedFile) {
                    $this->info("✓ Файл черновика удален");
                } else {
                    $this->warn("⚠ Файл не был найден (не удалялся)");
                }
                
                if ($deletedDb) {
                    $this->info("✓ Запись в БД удалена");
                } else {
                    $this->warn("⚠ Запись в БД не была найдена (не удалялась)");
                }

                return 0;
            });
        } catch (\Exception $e) {
            $this->error("Ошибка при удалении: " . $e->getMessage());
            $this->error("Изменения откачены (транзакция отменена)");
            return 1;
        }
    }
}

