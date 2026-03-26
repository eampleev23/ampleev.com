<?php

namespace App\Console\Commands;

use App\Article;
use App\BlogSection;
use App\User;
use App\Helpers\Transliterator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use DOMDocument;
use DOMXPath;

class PublishArticle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publish {text_url : text_url статьи для публикации}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Публикует черновик статьи (устанавливает confirmed=1 и дату публикации)';

    private const ARTICLE_LAYOUT_CLASSIC = 'classic';
    private const ARTICLE_LAYOUT_IMAGE_HEADER = 'image-header';
    private const ARTICLE_LAYOUT_PARALLAX = 'parallax';

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
        if (!File::exists($draftPath)) {
            $this->error("Файл черновика не найден: {$filename}");
            return 1;
        }

        // Ищем статью в БД
        $article = Article::where('text_url', $textUrl)->first();

        if (!$article) {
            $this->error("Статья с text_url '{$textUrl}' не найдена в базе данных.");
            $this->info("Сначала откройте preview: http://localhost:8000/drafts/{$textUrl}");
            return 1;
        }

        // Читаем файл для валидации
        $htmlContent = File::get($draftPath);
        $meta = $this->parseMeta($htmlContent);
        $contentParts = $this->extractContent($htmlContent);

        // Валидация обязательных полей
        $required = ['title', 'seo_description', 'blog_section', 'user_id', 'main_image_path', 'html_title'];
        foreach ($required as $field) {
            if (empty($meta[$field])) {
                $this->error("Обязательное поле отсутствует в метаданных: {$field}");
                return 1;
            }
        }

        if (empty($contentParts['first_paragraph'])) {
            $this->error("Обязательное поле отсутствует: first_paragraph");
            return 1;
        }

        if (empty($contentParts['content'])) {
            $this->error("Обязательное поле отсутствует: content");
            return 1;
        }

        // Проверяем user_id
        $user = User::find($meta['user_id']);
        if (!$user) {
            $this->error("Пользователь с ID {$meta['user_id']} не найден");
            return 1;
        }

        // Проверяем blog_section
        $blogSection = BlogSection::where('title', $meta['blog_section'])->first();
        if (!$blogSection) {
            if ($this->confirm("Раздел блога '{$meta['blog_section']}' не найден. Создать новый раздел?")) {
                $blogSection = new BlogSection();
                $blogSection->title = $meta['blog_section'];
                $blogSection->save();
                $this->info("Создан новый раздел блога: {$meta['blog_section']}");
            } else {
                $this->error("Публикация отменена. Создайте раздел блога вручную.");
                return 1;
            }
        }

        // Проверяем, изменился ли заголовок статьи
        $oldTextUrl = $textUrl;
        $newTextUrl = Transliterator::generateTextUrl($meta['title']);
        $textUrlChanged = ($oldTextUrl !== $newTextUrl);

        if ($textUrlChanged) {
            $this->info("Заголовок статьи изменился:");
            $this->line("  Старый: {$article->title} (text_url: {$oldTextUrl})");
            $this->line("  Новый: {$meta['title']} (text_url: {$newTextUrl})");

            // Проверяем, не занят ли новый text_url другой статьей
            $existingArticle = Article::where('text_url', $newTextUrl)
                ->where('id', '!=', $article->id)
                ->first();

            if ($existingArticle) {
                $this->error("Статья с text_url '{$newTextUrl}' уже существует (ID: {$existingArticle->id}, confirmed: {$existingArticle->confirmed})");
                return 1;
            }

            // Переименовываем файл черновика
            $oldFilename = $oldTextUrl . '.html';
            $newFilename = $newTextUrl . '.html';
            $oldDraftPath = storage_path('drafts/' . $oldFilename);
            $newDraftPath = storage_path('drafts/' . $newFilename);

            if (File::exists($newDraftPath)) {
                $this->error("Файл с новым text_url уже существует: {$newFilename}");
                return 1;
            }

            if (File::move($oldDraftPath, $newDraftPath)) {
                $this->info("✓ Файл переименован: {$oldFilename} → {$newFilename}");
                $textUrl = $newTextUrl;
                $draftPath = $newDraftPath;
            } else {
                $this->error("Ошибка при переименовании файла");
                return 1;
            }
        }

        // Проверяем, не занят ли text_url другой опубликованной статьей
        $existingPublished = Article::where('text_url', $textUrl)
            ->where('confirmed', 1)
            ->where('id', '!=', $article->id)
            ->first();

        if ($existingPublished) {
            $this->error("Статья с text_url '{$textUrl}' уже опубликована (ID: {$existingPublished->id})");
            return 1;
        }

        // Проверяем наличие комментариев к черновику
        $commentsCount = $article->comments()->count();
        $publishComments = false;
        
        if ($commentsCount > 0) {
            $this->info("Найдено комментариев к черновику: {$commentsCount}");
            $publishComments = $this->confirm('Опубликовать комментарии вместе со статьей?', true);
        }

        // Проверяем наличие просмотров
        $viewsCount = $article->views_count;
        $resetViews = false;
        
        if ($viewsCount > 0) {
            $this->info("Текущее количество просмотров: {$viewsCount}");
            $resetViews = $this->confirm('Обнулить количество просмотров при публикации?', false);
        }

        // Обновляем все поля статьи из метаданных
        $now = now();
        $article->title = $meta['title'];
        $article->seo_description = $meta['seo_description'];
        $article->html_title = $meta['html_title'];
        $article->main_image_path = $meta['main_image_path'];
        $article->hero_image_path = $this->normalizeHeroImagePath($meta['hero_image_path'] ?? null, $meta['main_image_path'] ?? null, $article->hero_image_path ?? null);
        $article->article_layout = $this->normalizeArticleLayout($meta['layout'] ?? null, $article->article_layout ?? null);
        $article->text_url = $textUrl; // Обновляем text_url (может быть новый)
        $article->blog_section_id = $blogSection->id;
        $article->first_paragraph = $contentParts['first_paragraph'];
        $article->content = $contentParts['content'];
        $article->confirmed = 1;
        $article->created_at = $now;
        $article->updated_at = $now;
        
        // Обнуляем просмотры, если пользователь выбрал
        if ($resetViews) {
            $article->views_count = 0;
            // Также удаляем записи о просмотрах
            $article->viewsArticles()->delete();
            $this->info("✓ Просмотры обнулены");
        }
        
        $article->save();

        // Если комментарии не публикуются - удаляем их
        if ($commentsCount > 0 && !$publishComments) {
            $article->comments()->delete();
            $this->info("✓ Комментарии к черновику удалены");
        }

        $this->newLine();
        $this->info("=== Статья успешно опубликована! ===");
        $appUrl = rtrim(env('APP_URL'), '/');
        $this->info("URL: {$appUrl}/article_{$textUrl}");
        $this->info("Дата публикации: {$now->format('Y-m-d H:i:s')}");
        
        if ($textUrlChanged) {
            $this->info("✓ text_url обновлен: {$oldTextUrl} → {$newTextUrl}");
        }
        
        if ($publishComments && $commentsCount > 0) {
            $this->info("✓ Комментарии опубликованы ({$commentsCount})");
        }
        
        if (!$resetViews && $viewsCount > 0) {
            $this->info("✓ Просмотры сохранены ({$viewsCount})");
        }

        return 0;
    }

    /**
     * Парсит метаданные из HTML head
     */
    private function parseMeta($htmlContent)
    {
        $meta = [];

        $dom = new DOMDocument();
        @$dom->loadHTML('<?xml encoding="UTF-8">' . $htmlContent);
        $xpath = new DOMXPath($dom);

        $metaTags = $xpath->query('//meta[@name]');
        foreach ($metaTags as $tag) {
            $name = $tag->getAttribute('name');
            $content = $tag->getAttribute('content');
            
            if (strpos($name, 'article-') === 0) {
                $key = str_replace('article-', '', $name);
                $key = str_replace('-', '_', $key);
                $value = $content;
                
                // Для html_title убираем теги <h1>, так как шаблон сам добавляет их
                if ($key === 'html_title') {
                    $value = preg_replace('/<\/?h1[^>]*>/i', '', $value);
                    $value = trim($value);
                }
                
                $meta[$key] = $value;
            }
        }

        return $meta;
    }

    /**
     * Извлекает first_paragraph и content из body
     */
    private function extractContent($htmlContent)
    {
        $dom = new DOMDocument();
        @$dom->loadHTML('<?xml encoding="UTF-8">' . $htmlContent);
        $xpath = new DOMXPath($dom);

        $result = [
            'first_paragraph' => '',
            'content' => '',
        ];

        $firstParagraphNodes = $xpath->query('//div[@class="first-paragraph"]');
        if ($firstParagraphNodes->length > 0) {
            $firstParagraphHtml = '';
            foreach ($firstParagraphNodes->item(0)->childNodes as $node) {
                $firstParagraphHtml .= $dom->saveHTML($node);
            }
            $result['first_paragraph'] = trim($firstParagraphHtml);
        }

        $contentNodes = $xpath->query('//div[@class="content"]');
        if ($contentNodes->length > 0) {
            $contentHtml = '';
            foreach ($contentNodes->item(0)->childNodes as $node) {
                $contentHtml .= $dom->saveHTML($node);
            }
            $result['content'] = trim($contentHtml);
        }

        return $result;
    }

    private function normalizeArticleLayout(?string $value, ?string $fallback): string
    {
        $value = is_string($value) ? trim(mb_strtolower($value)) : '';
        if ($value === '') {
            $fallback = is_string($fallback) && $fallback !== '' ? $fallback : self::ARTICLE_LAYOUT_CLASSIC;
            return $fallback;
        }

        if (in_array($value, [
            self::ARTICLE_LAYOUT_CLASSIC,
            self::ARTICLE_LAYOUT_IMAGE_HEADER,
            self::ARTICLE_LAYOUT_PARALLAX,
        ], true)) {
            return $value;
        }

        throw new \RuntimeException("Некорректное значение article-layout: {$value}. Допустимо: classic|image-header|parallax");
    }

    private function normalizeHeroImagePath(?string $value, ?string $mainImagePath, ?string $fallback): string
    {
        $value = is_string($value) ? trim($value) : '';
        if ($value !== '') {
            return $value;
        }

        $mainImagePath = is_string($mainImagePath) ? trim($mainImagePath) : '';
        if ($mainImagePath !== '') {
            return $mainImagePath;
        }

        return is_string($fallback) ? trim($fallback) : '';
    }
}
