<?php

namespace App\Console\Commands;

use App\Article;
use App\Support\SiteLocale;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeArticleEn extends Command
{
    protected $signature = 'make:article-en {text_url : text_url русской статьи}';

    protected $description = 'Создает HTML-черновик английской версии статьи';

    public function handle()
    {
        $textUrl = (string) $this->argument('text_url');
        $article = Article::with(['blog_section', 'translations'])->where('text_url', $textUrl)->first();

        if (!$article) {
            $this->error("Русская статья с text_url '{$textUrl}' не найдена.");
            return 1;
        }

        $draftDir = storage_path('drafts/en');
        if (!File::exists($draftDir)) {
            File::makeDirectory($draftDir, 0755, true);
        }

        $draftPath = $draftDir . '/' . $textUrl . '.html';
        if (File::exists($draftPath) && !$this->confirm('EN-черновик уже существует. Перезаписать его?', false)) {
            $this->info('Создание EN-черновика отменено.');
            return 0;
        }

        $translation = $article->translation(SiteLocale::EN);
        $template = $this->createTemplate($article, $translation, $textUrl);
        File::put($draftPath, $template);

        $this->info("EN-черновик создан: storage/drafts/en/{$textUrl}.html");
        $this->info("Preview: http://localhost:8000/en/drafts/{$textUrl}");
        $this->info("Публикация: php artisan publish {$textUrl} --lang=en");

        return 0;
    }

    private function createTemplate(Article $article, $translation, string $baseTextUrl): string
    {
        $previewUrl = "http://localhost:8000/en/drafts/{$baseTextUrl}";
        $title = htmlspecialchars((string) ($translation->title ?? $article->title), ENT_QUOTES, 'UTF-8');
        $seoDescription = htmlspecialchars((string) ($translation->seo_description ?? $article->seo_description), ENT_QUOTES, 'UTF-8');
        $blogSection = htmlspecialchars((string) $article->blog_section->title, ENT_QUOTES, 'UTF-8');
        $userId = $article->user_id;
        $mainImagePath = htmlspecialchars((string) ($translation->main_image_path ?? $article->main_image_path), ENT_QUOTES, 'UTF-8');
        $heroImagePath = htmlspecialchars((string) ($translation->hero_image_path ?? $article->hero_image_path ?? $article->main_image_path), ENT_QUOTES, 'UTF-8');
        $articleLayout = htmlspecialchars((string) ($translation->article_layout ?? $article->article_layout ?? Article::LAYOUT_CLASSIC), ENT_QUOTES, 'UTF-8');
        $htmlTitle = htmlspecialchars((string) ($translation->html_title ?? $article->html_title), ENT_QUOTES, 'UTF-8');
        $firstParagraph = (string) ($translation->first_paragraph ?? $article->first_paragraph);
        $content = (string) ($translation->content ?? $article->content);
        $mainImageMode = htmlspecialchars((string) ($article->main_image_mode ?? 'static'), ENT_QUOTES, 'UTF-8');

        return <<<HTML
<!-- Preview: {$previewUrl} -->
<!-- EN draft for RU article: {$baseTextUrl} (article ID: {$article->id}) -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="article-title" content="{$title}">
    <meta name="article-seo-description" content="{$seoDescription}">
    <meta name="article-blog-section" content="{$blogSection}">
    <meta name="article-user-id" content="{$userId}">
    <meta name="article-main-image-path" content="{$mainImagePath}">
    <meta name="article-hero-image-path" content="{$heroImagePath}">
    <meta name="article-main-image-mode" content="{$mainImageMode}">
    <meta name="article-layout" content="{$articleLayout}">
    <meta name="article-html-title" content="{$htmlTitle}">
</head>
<body>
    <div class="first-paragraph">
        {$firstParagraph}
    </div>

    <div class="content">
        {$content}
    </div>
</body>
</html>
HTML;
    }
}
