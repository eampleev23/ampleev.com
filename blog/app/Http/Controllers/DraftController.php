<?php

namespace App\Http\Controllers;

use App\Article;
use App\BlogSection;
use App\User;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use DOMDocument;
use DOMXPath;

class DraftController extends Controller
{
    private const MAIN_IMAGE_MODE_ZOOM = 'zoom';
    private const MAIN_IMAGE_MODE_STATIC = 'static';
    private const ARTICLE_LAYOUT_CLASSIC = 'classic';
    private const ARTICLE_LAYOUT_IMAGE_HEADER = 'image-header';
    private const ARTICLE_LAYOUT_PARALLAX = 'parallax';

    /**
     * Показывает preview черновика статьи
     */
    public function preview($textUrl)
    {
        // Preview черновиков нужен только локально
        if (!app()->environment('local')) {
            abort(404);
        }

        // Иногда в URL попадает префикс article_ (по аналогии с /article_{text_url})
        // Поддерживаем оба варианта: /drafts/{text_url} и /drafts/article_{text_url}
        if (is_string($textUrl) && str_starts_with($textUrl, 'article_')) {
            $textUrl = substr($textUrl, strlen('article_'));
        }

        $filename = $textUrl . '.html';
        $draftPath = storage_path('drafts/' . $filename);

        if (!File::exists($draftPath)) {
            abort(404, 'Файл черновика не найден: ' . $filename);
        }

        // Читаем файл
        $htmlContent = File::get($draftPath);
        $fileModifiedTime = File::lastModified($draftPath);

        // Парсим метаданные и контент
        $meta = $this->parseMeta($htmlContent);
        $contentParts = $this->extractContent($htmlContent);

        // Генерируем text_url из title автоматически (всегда)
        if (empty($meta['title'])) {
            abort(400, "Обязательное поле отсутствует в метаданных: title");
        }
        $generatedTextUrl = \App\Helpers\Transliterator::generateTextUrl($meta['title']);
        $meta['text_url'] = $generatedTextUrl;

        // Проверяем, существует ли статья в БД (ищем по сгенерированному text_url)
        $article = Article::where('text_url', $generatedTextUrl)->first();

        // Если файл новее записи в БД или записи нет - обновляем/создаем
        $shouldUpdate = false;
        if (!$article) {
            $shouldUpdate = true;
        } else {
            $dbUpdatedTime = strtotime($article->updated_at);
            if ($fileModifiedTime > $dbUpdatedTime) {
                $shouldUpdate = true;
            }
        }

        if ($shouldUpdate) {
            $article = $this->syncDraftToDatabase($meta, $contentParts, $article);
        }

        // Загружаем связи и счетчик комментариев
        $article->load(['user', 'blog_section']);
        $article->loadCount('comments');
        
        // Генерируем HTML комментариев
        $commentsHtml = Comment::getAllCommentsHtml($article);

        // Получаем последние статьи для футера
        $last_articles = Article::with(['user', 'blog_section'])
            ->orderBy('views_count', 'desc')
            ->where('confirmed', '=', '1')
            ->where('type_article', '=', "article")
            ->limit(2)
            ->get();

        // Получаем случайные статьи для related_stories
        $random_articles = Article::getRandomArticles($article->id, 3, null);
        $cursorExperienceArticle = Article::with(['user', 'blog_section'])
            ->where('text_url', '=', 'moy_opyt_ispolzovaniya_cursor')
            ->where('type_article', '=', 'article')
            ->first();

        $active_menu_item = 'Блог';

        return view('drafts.preview', [
            'article' => $article,
            'commentsHtml' => $commentsHtml,
            'active_menu_item' => $active_menu_item,
            'last_articles' => $last_articles,
            'random_articles' => $random_articles,
            'cursorExperienceArticle' => $cursorExperienceArticle,
        ]);
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

        // Извлекаем мета-теги
        $metaTags = $xpath->query('//meta[@name]');
        foreach ($metaTags as $tag) {
            $name = $tag->getAttribute('name');
            $content = $tag->getAttribute('content');
            
            if (strpos($name, 'article-') === 0) {
                $key = str_replace('article-', '', $name);
                // Преобразуем kebab-case в snake_case
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
            'first_paragraph' => null, // null означает, что блок не найден в файле
            'content' => null, // null означает, что блок не найден в файле
        ];

        // Ищем first-paragraph (извлекаем только параграфы, исключая изображения)
        $firstParagraphNodes = $xpath->query('//div[@class="first-paragraph"]');
        if ($firstParagraphNodes->length > 0) {
            $firstParagraphHtml = '';
            foreach ($firstParagraphNodes->item(0)->childNodes as $node) {
                // Пропускаем изображения - они отображаются отдельно
                if ($node->nodeName === 'img') {
                    continue;
                }
                $firstParagraphHtml .= $dom->saveHTML($node);
            }
            $result['first_paragraph'] = trim($firstParagraphHtml);
        }

        // Ищем content
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

    /**
     * Синхронизирует черновик с БД
     */
    private function syncDraftToDatabase($meta, $contentParts, $existingArticle = null)
    {
        // Валидация обязательных полей (text_url генерируется автоматически из title)
        $required = ['title', 'seo_description', 'blog_section', 'user_id', 'main_image_path', 'html_title'];
        foreach ($required as $field) {
            if (empty($meta[$field])) {
                abort(400, "Обязательное поле отсутствует в метаданных: {$field}");
            }
        }

        // Нормализуем режим увеличения изображений (по умолчанию — static для черновиков, если мета-тег не указан)
        $mainImageMode = $this->normalizeMainImageMode($meta['main_image_mode'] ?? null);
        $articleLayout = $this->normalizeArticleLayout($meta['article_layout'] ?? null);
        $heroImagePath = $this->normalizeHeroImagePath($meta['hero_image_path'] ?? null, $meta['main_image_path'] ?? null);
        
        // Генерируем text_url из title
        $meta['text_url'] = \App\Helpers\Transliterator::generateTextUrl($meta['title']);

        // Если блоки контента не найдены в файле (null) - используем пустую строку
        // Если блоки найдены, но пустые - тоже используем пустую строку
        // Это гарантирует, что удаленный из файла контент не будет показываться в preview
        if ($contentParts['first_paragraph'] === null) {
            $contentParts['first_paragraph'] = '';
        }

        if ($contentParts['content'] === null) {
            $contentParts['content'] = '';
        }

        // Проверяем user_id
        $user = User::find($meta['user_id']);
        if (!$user) {
            abort(400, "Пользователь с ID {$meta['user_id']} не найден");
        }

        // Проверяем/создаем blog_section
        $blogSection = BlogSection::where('title', $meta['blog_section'])->first();
        if (!$blogSection) {
            // Автоматически создаем раздел в preview
            $blogSection = new BlogSection();
            $blogSection->title = $meta['blog_section'];
            $blogSection->save();
        }

        // Создаем или обновляем статью
        if ($existingArticle) {
            $article = $existingArticle;
        } else {
            $article = new Article();
            $article->confirmed = 0;
            $article->type_article = 'article';
            $article->views_count = 0;
            $article->likes_count = 0;
        }

        $article->title = $meta['title'];
        $article->seo_description = $meta['seo_description'];
        $article->html_title = $meta['html_title'];
        $article->text_url = $meta['text_url'];
        $article->main_image_path = $meta['main_image_path'];
        $article->main_image_mode = $mainImageMode;
        $article->article_layout = $articleLayout;
        $article->hero_image_path = $heroImagePath;
        $article->user_id = $meta['user_id'];
        $article->blog_section_id = $blogSection->id;
        $article->first_paragraph = $contentParts['first_paragraph'];
        $article->content = $contentParts['content'];
        
        $article->save();

        return $article;
    }

    private function normalizeMainImageMode(?string $value): string
    {
        $value = is_string($value) ? trim(mb_strtolower($value)) : '';

        if ($value === '') {
            return self::MAIN_IMAGE_MODE_STATIC;
        }

        if (in_array($value, [self::MAIN_IMAGE_MODE_ZOOM, self::MAIN_IMAGE_MODE_STATIC], true)) {
            return $value;
        }

        abort(400, "Некорректное значение article-main-image-mode: {$value}. Допустимо: zoom|static");
    }

    private function normalizeArticleLayout(?string $value): string
    {
        $value = is_string($value) ? trim(mb_strtolower($value)) : '';

        if ($value === '') {
            return self::ARTICLE_LAYOUT_CLASSIC;
        }

        if (in_array($value, [
            self::ARTICLE_LAYOUT_CLASSIC,
            self::ARTICLE_LAYOUT_IMAGE_HEADER,
            self::ARTICLE_LAYOUT_PARALLAX,
        ], true)) {
            return $value;
        }

        abort(400, "Некорректное значение article-layout: {$value}. Допустимо: classic|image-header|parallax");
    }

    private function normalizeHeroImagePath(?string $value, ?string $fallback): string
    {
        $value = is_string($value) ? trim($value) : '';
        if ($value !== '') {
            return $value;
        }

        return is_string($fallback) ? trim($fallback) : '';
    }
}
