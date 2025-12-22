<?php

namespace App\Console\Commands;

use App\Article;
use App\BlogSection;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
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

        // Проверяем, не занят ли text_url другой опубликованной статьей
        $existingPublished = Article::where('text_url', $textUrl)
            ->where('confirmed', 1)
            ->where('id', '!=', $article->id)
            ->first();

        if ($existingPublished) {
            $this->error("Статья с text_url '{$textUrl}' уже опубликована (ID: {$existingPublished->id})");
            return 1;
        }

        // Публикуем статью
        $now = now();
        $article->confirmed = 1;
        $article->created_at = $now;
        $article->updated_at = $now;
        $article->save();

        $this->info("Статья успешно опубликована!");
        $this->info("URL: http://localhost:8000/article_{$textUrl}");
        $this->info("Дата публикации: {$now->format('Y-m-d H:i:s')}");

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
}

