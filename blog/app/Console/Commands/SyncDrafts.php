<?php

namespace App\Console\Commands;

use App\Article;
use App\BlogSection;
use App\User;
use DOMDocument;
use DOMXPath;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SyncDrafts extends Command
{
    protected $signature = 'drafts:sync
                            {--dry-run : Не сохранять изменения, только показать что было бы обновлено}
                            {--only= : Синкнуть только один text_url (имя файла без .html)}';

    protected $description = 'Синхронизирует опубликованные статьи (confirmed=1) из HTML-черновиков storage/drafts/*.html по хешу содержимого';

    private const MAIN_IMAGE_MODE_ZOOM = 'zoom';
    private const MAIN_IMAGE_MODE_STATIC = 'static';
    private const ARTICLE_LAYOUT_CLASSIC = 'classic';
    private const ARTICLE_LAYOUT_IMAGE_HEADER = 'image-header';
    private const ARTICLE_LAYOUT_PARALLAX = 'parallax';

    public function handle(): int
    {
        $draftDir = storage_path('drafts');
        if (!File::isDirectory($draftDir)) {
            $this->error("Директория черновиков не найдена: {$draftDir}");
            return 1;
        }

        $only = $this->option('only');
        $only = is_string($only) ? trim($only) : null;
        if ($only === '') {
            $only = null;
        }

        $draftFiles = File::files($draftDir);
        $updated = 0;
        $skipped = 0;
        $notFound = 0;
        $errors = 0;

        foreach ($draftFiles as $file) {
            if ($file->getExtension() !== 'html') {
                continue;
            }

            $textUrl = $file->getFilenameWithoutExtension();
            if ($only && $textUrl !== $only) {
                continue;
            }

            // Ищем только опубликованные статьи
            $article = Article::with('blog_section')->where('text_url', $textUrl)->where('confirmed', 1)->first();
            if (!$article) {
                $notFound++;
                continue;
            }

            try {
                $html = File::get($file->getPathname());
                $meta = $this->parseMeta($html);
                $contentParts = $this->extractContent($html);

                $draftNormalized = $this->normalizeDraft($textUrl, $meta, $contentParts, $article);
                $draftHash = $this->computeDraftHash($draftNormalized);

                $currentHash = $this->computeCurrentArticleHash($article);

                if ($draftHash === $currentHash && $article->draft_hash === $draftHash) {
                    $skipped++;
                    continue;
                }

                // Если хеши совпадают, но draft_hash еще не проставлен — просто проставим
                if ($draftHash === $currentHash && $article->draft_hash !== $draftHash) {
                    if (!$this->option('dry-run')) {
                        $article->draft_hash = $draftHash;
                        $article->save();
                    }
                    $this->line("HASH SET: {$textUrl}");
                    $updated++;
                    continue;
                }

                if ($this->option('dry-run')) {
                    $this->line("WOULD UPDATE: {$textUrl}");
                    $updated++;
                    continue;
                }

                $this->applyDraftToArticle($article, $draftNormalized, $draftHash);
                $this->line("UPDATED: {$textUrl}");
                $updated++;
            } catch (\Throwable $e) {
                $errors++;
                $this->error("ERROR: {$textUrl} — {$e->getMessage()}");
            }
        }

        $this->info("Done. Updated: {$updated}, Skipped: {$skipped}, Not found: {$notFound}, Errors: {$errors}");
        return $errors > 0 ? 1 : 0;
    }

    private function parseMeta(string $htmlContent): array
    {
        $meta = [];

        $dom = new DOMDocument();
        @$dom->loadHTML('<?xml encoding="UTF-8">' . $htmlContent);
        $xpath = new DOMXPath($dom);

        $metaTags = $xpath->query('//meta[@name]');
        foreach ($metaTags as $tag) {
            $name = $tag->getAttribute('name');
            $content = $tag->getAttribute('content');

            if (strpos($name, 'article-') !== 0) {
                continue;
            }

            $key = str_replace('article-', '', $name);
            $key = str_replace('-', '_', $key);
            $value = $content;

            if ($key === 'html_title') {
                $value = preg_replace('/<\/?h1[^>]*>/i', '', $value);
                $value = trim($value);
            }

            $meta[$key] = $value;
        }

        return $meta;
    }

    private function extractContent(string $htmlContent): array
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
                if ($node->nodeName === 'img') {
                    continue;
                }
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

    private function normalizeDraft(string $textUrl, array $meta, array $contentParts, Article $existingArticle): array
    {
        // text_url для синка берём из имени файла, чтобы можно было менять title без смены URL
        $title = trim((string) ($meta['title'] ?? ''));
        $seoDescription = trim((string) ($meta['seo_description'] ?? ''));
        $htmlTitle = trim((string) ($meta['html_title'] ?? ''));
        $mainImagePath = trim((string) ($meta['main_image_path'] ?? ''));
        $heroImagePath = trim((string) ($meta['hero_image_path'] ?? ''));

        if ($title === '') {
            throw new \RuntimeException('meta article-title пустой');
        }

        // Разрешаем не указывать html_title: тогда используем title
        if ($htmlTitle === '') {
            $htmlTitle = $title;
        }

        $mainImageMode = $this->normalizeMainImageMode($meta['main_image_mode'] ?? null, $existingArticle->main_image_mode ?? null);
        $articleLayout = $this->normalizeArticleLayout($meta['layout'] ?? null, $existingArticle->article_layout ?? null);

        // blog_section
        $blogSectionTitle = trim((string) ($meta['blog_section'] ?? ''));
        if ($blogSectionTitle !== '') {
            $blogSection = BlogSection::where('title', $blogSectionTitle)->first();
            if (!$blogSection) {
                $blogSection = new BlogSection();
                $blogSection->title = $blogSectionTitle;
                $blogSection->save();
            }
            $blogSectionId = $blogSection->id;
        } else {
            $blogSectionId = $existingArticle->blog_section_id;
            $blogSectionTitle = $existingArticle->blog_section ? $existingArticle->blog_section->title : '';
        }

        // user_id
        $userId = $existingArticle->user_id;
        if (!empty($meta['user_id'])) {
            $candidate = (int) $meta['user_id'];
            if ($candidate > 0) {
                $user = User::find($candidate);
                if ($user) {
                    $userId = $candidate;
                }
            }
        }

        // main image path: если пусто — оставляем текущий (чтобы не сломать OG)
        if ($mainImagePath === '') {
            $mainImagePath = (string) ($existingArticle->main_image_path ?? '');
        }

        if ($heroImagePath === '') {
            $heroImagePath = (string) ($existingArticle->hero_image_path ?? $mainImagePath);
        }

        return [
            'text_url' => $textUrl,
            'title' => $title,
            'seo_description' => $seoDescription,
            'html_title' => $htmlTitle,
            'main_image_path' => $mainImagePath,
            'hero_image_path' => $heroImagePath,
            'main_image_mode' => $mainImageMode,
            'article_layout' => $articleLayout,
            'blog_section_id' => $blogSectionId,
            'blog_section_title' => $blogSectionTitle,
            'user_id' => $userId,
            'first_paragraph' => (string) ($contentParts['first_paragraph'] ?? ''),
            'content' => (string) ($contentParts['content'] ?? ''),
        ];
    }

    private function normalizeMainImageMode(?string $value, ?string $fallback): string
    {
        $value = is_string($value) ? trim(mb_strtolower($value)) : '';
        if ($value === '') {
            $fallback = is_string($fallback) && $fallback !== '' ? $fallback : self::MAIN_IMAGE_MODE_ZOOM;
            return $fallback;
        }

        if (in_array($value, [self::MAIN_IMAGE_MODE_ZOOM, self::MAIN_IMAGE_MODE_STATIC], true)) {
            return $value;
        }

        throw new \RuntimeException("Некорректное значение article-main-image-mode: {$value}. Допустимо: zoom|static");
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

    private function computeDraftHash(array $draft): string
    {
        $payload = json_encode([
            'text_url' => $draft['text_url'],
            'title' => $draft['title'],
            'seo_description' => $draft['seo_description'],
            'html_title' => $draft['html_title'],
            'main_image_path' => $draft['main_image_path'],
            'hero_image_path' => $draft['hero_image_path'],
            'main_image_mode' => $draft['main_image_mode'],
            'article_layout' => $draft['article_layout'],
            'blog_section_title' => $draft['blog_section_title'],
            'user_id' => $draft['user_id'],
            'first_paragraph' => $draft['first_paragraph'],
            'content' => $draft['content'],
        ], JSON_UNESCAPED_UNICODE);

        return hash('sha256', $payload ?: '');
    }

    private function computeCurrentArticleHash(Article $article): string
    {
        $payload = json_encode([
            'text_url' => $article->text_url,
            'title' => (string) $article->title,
            'seo_description' => (string) $article->seo_description,
            'html_title' => (string) $article->html_title,
            'main_image_path' => (string) $article->main_image_path,
            'hero_image_path' => (string) ($article->hero_image_path ?? $article->main_image_path),
            'main_image_mode' => (string) ($article->main_image_mode ?? self::MAIN_IMAGE_MODE_ZOOM),
            'article_layout' => (string) ($article->article_layout ?? self::ARTICLE_LAYOUT_CLASSIC),
            'blog_section_title' => $article->blog_section ? (string) $article->blog_section->title : '',
            'user_id' => (int) $article->user_id,
            'first_paragraph' => (string) $article->first_paragraph,
            'content' => (string) $article->content,
        ], JSON_UNESCAPED_UNICODE);

        return hash('sha256', $payload ?: '');
    }

    private function applyDraftToArticle(Article $article, array $draft, string $draftHash): void
    {
        $article->title = $draft['title'];
        $article->seo_description = $draft['seo_description'];
        $article->html_title = $draft['html_title'];
        $article->main_image_path = $draft['main_image_path'];
        $article->hero_image_path = $draft['hero_image_path'];
        $article->main_image_mode = $draft['main_image_mode'];
        $article->article_layout = $draft['article_layout'];
        $article->user_id = $draft['user_id'];
        $article->blog_section_id = $draft['blog_section_id'];
        $article->first_paragraph = $draft['first_paragraph'];
        $article->content = $draft['content'];
        $article->draft_hash = $draftHash;

        $article->save();
    }
}
