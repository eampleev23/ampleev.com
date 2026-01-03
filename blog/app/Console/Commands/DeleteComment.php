<?php

namespace App\Console\Commands;

use App\Comment;
use App\Article;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteComment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comment:delete {id : ID комментария для удаления}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удаляет комментарий по ID (включая все дочерние комментарии)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $commentId = $this->argument('id');
        
        // Ищем комментарий
        $comment = Comment::with(['user', 'article'])->find($commentId);
        
        if (!$comment) {
            $this->error("Комментарий с ID {$commentId} не найден!");
            return 1;
        }
        
        // Показываем информацию о комментарии
        $this->info("=== Информация о комментарии ===");
        $this->line("ID: {$comment->id}");
        $this->line("Автор: {$comment->user->name} (ID: {$comment->user->id})");
        $this->line("Статья: {$comment->article->title} (ID: {$comment->article->id})");
        $this->line("URL статьи: /article_{$comment->article->text_url}");
        $this->line("Дата создания: {$comment->created_at}");
        $this->line("Контент: " . substr(strip_tags($comment->content), 0, 100) . (strlen($comment->content) > 100 ? '...' : ''));
        
        // Подсчитываем дочерние комментарии
        $childCommentsCount = $this->countChildComments($comment->id);
        if ($childCommentsCount > 0) {
            $this->warn("⚠️  Внимание: у этого комментария есть {$childCommentsCount} дочерних комментариев, которые также будут удалены!");
        }
        
        $this->newLine();
        
        // Запрашиваем подтверждение
        if (!$this->confirm('Вы уверены, что хотите удалить этот комментарий?')) {
            $this->info('Удаление отменено.');
            return 0;
        }
        
        // Удаляем комментарий и все дочерние
        try {
            return DB::transaction(function () use ($comment, $childCommentsCount) {
                $deletedCount = $this->deleteCommentRecursive($comment->id);
                
                $this->newLine();
                $this->info("✅ Комментарий успешно удален!");
                $this->line("Удалено комментариев: {$deletedCount}");
                
                if ($childCommentsCount > 0) {
                    $this->line("  - Основной комментарий: 1");
                    $this->line("  - Дочерние комментарии: " . ($deletedCount - 1));
                }
                
                return 0;
            });
        } catch (\Exception $e) {
            $this->error("Ошибка при удалении комментария: " . $e->getMessage());
            return 1;
        }
    }
    
    /**
     * Рекурсивно удаляет комментарий и все его дочерние комментарии
     *
     * @param int $commentId
     * @return int Количество удаленных комментариев
     */
    private function deleteCommentRecursive($commentId)
    {
        $count = 0;
        
        // Находим все дочерние комментарии
        $childComments = Comment::where('comment_id', $commentId)->get();
        
        // Рекурсивно удаляем дочерние комментарии
        foreach ($childComments as $child) {
            $count += $this->deleteCommentRecursive($child->id);
        }
        
        // Удаляем сам комментарий
        Comment::where('id', $commentId)->delete();
        $count++;
        
        return $count;
    }
    
    /**
     * Подсчитывает количество дочерних комментариев (рекурсивно)
     *
     * @param int $commentId
     * @return int
     */
    private function countChildComments($commentId)
    {
        $count = 0;
        $childComments = Comment::where('comment_id', $commentId)->get();
        
        foreach ($childComments as $child) {
            $count++; // Считаем сам дочерний комментарий
            $count += $this->countChildComments($child->id); // Рекурсивно считаем его дочерние
        }
        
        return $count;
    }
}

