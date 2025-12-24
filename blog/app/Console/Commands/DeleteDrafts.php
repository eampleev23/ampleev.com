<?php

namespace App\Console\Commands;

use App\Article;
use App\Comment;
use App\ViewArticle;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class DeleteDrafts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:drafts {count : Количество последних черновиков для удаления}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удаляет последние X неопубликованных черновиков';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $count = (int) $this->argument('count');

        if ($count <= 0) {
            $this->error('Количество должно быть больше 0');
            return 1;
        }

        $this->info("Поиск последних {$count} неопубликованных черновиков...");
        $this->newLine();

        // 1. Находим черновики с записью в БД (confirmed = 0), отсортированные по created_at DESC
        $dbDrafts = Article::where('confirmed', 0)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($article) {
                return [
                    'text_url' => $article->text_url,
                    'title' => $article->title,
                    'date' => $article->created_at,
                    'has_db' => true,
                    'has_file' => File::exists(storage_path('drafts/' . $article->text_url . '.html')),
                    'article' => $article,
                ];
            });

        // 2. Собираем text_url черновиков с БД для исключения дубликатов
        $dbTextUrls = $dbDrafts->pluck('text_url')->toArray();
        
        // 3. Находим файлы черновиков БЕЗ записи в БД (чтобы избежать дубликатов)
        $draftsDir = storage_path('drafts');
        $allFiles = File::files($draftsDir);
        
        $fileDrafts = collect($allFiles)
            ->filter(function ($file) use ($dbTextUrls) {
                // Проверяем, что это HTML файл и нет записи в БД
                $filename = $file->getFilename();
                if (!str_ends_with($filename, '.html')) {
                    return false;
                }
                
                $textUrl = str_replace('.html', '', $filename);
                
                // Исключаем файлы, у которых уже есть запись в БД (чтобы избежать дубликатов)
                if (in_array($textUrl, $dbTextUrls)) {
                    return false;
                }
                
                // Проверяем, что запись в БД либо отсутствует, либо не опубликована
                $article = Article::where('text_url', $textUrl)->first();
                return !$article || $article->confirmed == 0;
            })
            ->map(function ($file) {
                $filename = $file->getFilename();
                $textUrl = str_replace('.html', '', $filename);
                $article = Article::where('text_url', $textUrl)->first();
                
                // Пытаемся извлечь title из файла
                $title = $textUrl; // По умолчанию
                try {
                    $htmlContent = File::get($file->getPathname());
                    $dom = new \DOMDocument();
                    @$dom->loadHTML($htmlContent);
                    $xpath = new \DOMXPath($dom);
                    $titleNode = $xpath->query("//meta[@name='article-title']")->item(0);
                    if ($titleNode) {
                        $title = $titleNode->getAttribute('content');
                    }
                } catch (\Exception $e) {
                    // Игнорируем ошибки парсинга
                }
                
                return [
                    'text_url' => $textUrl,
                    'title' => $title,
                    'date' => \Carbon\Carbon::createFromTimestamp($file->getMTime()),
                    'has_db' => $article !== null,
                    'has_file' => true,
                    'article' => $article,
                ];
            });

        // 4. Объединяем и сортируем по дате (записи из БД уже имеют приоритет)
        $allDrafts = $dbDrafts->concat($fileDrafts)
            ->sortByDesc(function ($draft) {
                // Сортируем по дате создания (created_at для БД, filemtime для файлов)
                return $draft['date']->timestamp;
            })
            ->take($count)
            ->values();

        if ($allDrafts->isEmpty()) {
            $this->warn('Не найдено неопубликованных черновиков для удаления.');
            return 0;
        }

        // 5. Показываем список найденных черновиков
        $this->info("Найдено черновиков для удаления: {$allDrafts->count()}");
        $this->newLine();
        $this->table(
            ['#', 'text_url', 'Название', 'Дата создания', 'В БД', 'Файл'],
            $allDrafts->map(function ($draft, $index) {
                return [
                    $index + 1,
                    $draft['text_url'],
                    $draft['title'],
                    $draft['date']->format('Y-m-d H:i:s'),
                    $draft['has_db'] ? '✓' : '✗',
                    $draft['has_file'] ? '✓' : '✗',
                ];
            })->toArray()
        );

        // 6. Запрашиваем подтверждение
        if (!$this->confirm("Вы уверены, что хотите удалить эти {$allDrafts->count()} черновиков?", false)) {
            $this->info('Удаление отменено.');
            return 0;
        }

        // 7. Удаляем каждый черновик
        $stats = [
            'total' => $allDrafts->count(),
            'deleted_files' => 0,
            'deleted_db' => 0,
            'deleted_comments' => 0,
            'deleted_views' => 0,
            'errors' => 0,
        ];

        $this->newLine();
        $this->info('Начинаем удаление...');
        $this->newLine();

        foreach ($allDrafts as $draft) {
            $textUrl = $draft['text_url'];
            $filename = $textUrl . '.html';
            $draftPath = storage_path('drafts/' . $filename);
            $article = $draft['article'];

            try {
                DB::transaction(function () use ($article, $draftPath, $textUrl, $filename, &$stats) {
                    // Удаляем файл
                    if (File::exists($draftPath)) {
                        if (File::delete($draftPath)) {
                            $stats['deleted_files']++;
                        } else {
                            throw new \Exception("Не удалось удалить файл: {$filename}");
                        }
                    }

                    // Удаляем запись из БД и связанные данные
                    if ($article) {
                        // Удаляем комментарии
                        $commentsCount = $article->comments()->count();
                        $article->comments()->delete();
                        $stats['deleted_comments'] += $commentsCount;

                        // Удаляем записи о просмотрах
                        $viewsCount = $article->viewsArticles()->count();
                        $article->viewsArticles()->delete();
                        $stats['deleted_views'] += $viewsCount;

                        // Удаляем саму статью
                        $article->delete();
                        $stats['deleted_db']++;
                    }
                });
            } catch (\Exception $e) {
                $stats['errors']++;
                $this->error("Ошибка при удалении '{$textUrl}': " . $e->getMessage());
            }
        }

        // 8. Показываем итоговую статистику
        $this->newLine();
        $this->info('=== Итоговый отчет ===');
        $this->info("Всего обработано: {$stats['total']}");
        $this->info("✓ Удалено файлов: {$stats['deleted_files']}");
        $this->info("✓ Удалено записей в БД: {$stats['deleted_db']}");
        $this->info("✓ Удалено комментариев: {$stats['deleted_comments']}");
        $this->info("✓ Удалено записей о просмотрах: {$stats['deleted_views']}");
        
        if ($stats['errors'] > 0) {
            $this->warn("⚠ Ошибок при удалении: {$stats['errors']}");
            return 1;
        }

        $this->info('Все черновики успешно удалены.');
        return 0;
    }
}

