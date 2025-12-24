<?php

namespace App\Console\Commands;

use App\Article;
use App\Helpers\Transliterator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use DOMDocument;
use DOMXPath;

class MakeArticle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:article {title : Название статьи (text_url будет сгенерирован автоматически)} {--template=basic-ru : Шаблон статьи (basic, basic-ru, video, image-header, parallax)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создает шаблон HTML файла для черновика статьи';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $title = $this->argument('title');
        $templateType = $this->option('template');
        $textUrl = Transliterator::generateTextUrl($title);
        $filename = $textUrl . '.html';
        $draftPath = storage_path('drafts/' . $filename);

        // Проверяем валидность шаблона
        $validTemplates = ['basic', 'basic-ru', 'video', 'image-header', 'parallax'];
        if (!in_array($templateType, $validTemplates)) {
            $this->error("Неверный шаблон. Доступные шаблоны: " . implode(', ', $validTemplates));
            return 1;
        }

        // Проверяем, существует ли файл
        if (File::exists($draftPath)) {
            $this->error("Файл черновика уже существует: {$filename}");
            return 1;
        }

        // Проверяем, не опубликована ли уже статья с таким text_url
        $publishedArticle = Article::with('blog_section')
            ->where('text_url', $textUrl)
            ->where('confirmed', 1)
            ->first();

        if ($publishedArticle) {
            $this->warn("⚠ Статья с таким заголовком уже опубликована!");
            $this->info("Опубликованная статья:");
            $this->line("  - ID: {$publishedArticle->id}");
            $this->line("  - Название: {$publishedArticle->title}");
            $this->line("  - URL: http://localhost:8000/article_{$textUrl}");
            $this->line("  - Дата публикации: {$publishedArticle->created_at->format('Y-m-d H:i:s')}");
            
            if (!$this->confirm('Создать черновик для редактирования этой статьи?', true)) {
                $this->info('Создание черновика отменено.');
                return 0;
            }

            // Создаем черновик на основе опубликованной статьи
            $template = $this->createDraftFromPublishedArticle($publishedArticle, $textUrl, $templateType);
        } else {
            // Создаем обычный шаблон
            $template = $this->getTemplate($title, $textUrl, $templateType);
        }

        // Сохраняем файл
        File::put($draftPath, $template);

        $this->info("Черновик создан: storage/drafts/{$filename}");
        $this->info("Шаблон: {$templateType}");
        $this->info("Preview: http://localhost:8000/drafts/{$textUrl}");
        $this->info("Не забудьте заполнить все мета-теги в <head>!");

        return 0;
    }

    /**
     * Возвращает HTML шаблон для черновика
     *
     * @param string $title
     * @param string $textUrl
     * @param string $templateType
     * @return string
     */
    private function getTemplate($title, $textUrl, $templateType = 'basic-ru')
    {
        switch ($templateType) {
            case 'basic':
                return $this->getBasicTemplate($title, $textUrl);
            case 'basic-ru':
                return $this->getBasicRuTemplate($title, $textUrl);
            case 'video':
                return $this->getVideoTemplate($title, $textUrl);
            case 'image-header':
                return $this->getImageHeaderTemplate($title, $textUrl);
            case 'parallax':
                return $this->getParallaxTemplate($title, $textUrl);
            default:
                return $this->getBasicRuTemplate($title, $textUrl);
        }
    }

    /**
     * Шаблон Basic - обычная статья с изображением
     */
    private function getBasicTemplate($title, $textUrl)
    {
        $previewUrl = "http://localhost:8000/drafts/{$textUrl}";
        return <<<HTML
<!-- Preview: {$previewUrl} -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="article-title" content="{$title}">
    <meta name="article-seo-description" content="Navigating the complexity of change aversion and understanding how to overcome resistance to new ideas and processes.">
    <meta name="article-blog-section" content="Agile">
    <meta name="article-user-id" content="1">
    <meta name="article-main-image-path" content="/assets/img/basic_template_main_img.jpeg">
    <meta name="article-html-title" content="{$title}">
</head>
<body>
    <!-- Первый параграф статьи (отображается отдельно) -->
    <div class="first-paragraph">
        <p class="lead" style="margin-bottom: 48px;">Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
    </div>
    
    <!-- Основной контент статьи -->
    <div class="content">
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
        
        <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
        
        <h4>A heading to shift focus</h4>
        
        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.</p>
        
        <figure>
            <img src="/assets/img/basic_template_img1.jpg" alt="A caption to describe the image" class="img-fluid rounded border">
            <figcaption>A caption to describe the image</figcaption>
        </figure>
        
        <p>Aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
        
        <blockquote class="bg-primary-alt">
            <div class="h3 mb-2">&ldquo;We couldn't have done it without the hard-working team from Leap.&rdquo;</div>
            <span class="text-small text-muted">– Harvey Dent (via Tareq I.)</span>
            <a href="#" class="btn btn-primary btn-sm">
                <img class="icon" src="/assets/img/icons/social/twitter.svg" alt="twitter social icon" data-inject-svg/>
                <span>Tweet</span>
            </a>
        </blockquote>
        
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
        
        <h5>A minor heading to summarise</h5>
        
        <p>Sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur?</p>
        
        <ul>
            <li>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam</li>
            <li>Corporis suscipit laboriosam</li>
            <li>Aspernatur aut odit aut fugit eos qui ratione</li>
            <li>Et quasi</li>
        </ul>
    </div>
</body>
</html>
HTML;
    }

    /**
     * Шаблон Basic-RU - обычная статья с изображением (русская версия)
     */
    private function getBasicRuTemplate($title, $textUrl)
    {
        $previewUrl = "http://localhost:8000/drafts/{$textUrl}";
        $quoteText = '"Мы бы не справились без трудолюбивой команды из Leap." – Харви Дент';
        $telegramShareUrl = "https://t.me/share/url?url=" . urlencode($previewUrl) . "&text=" . urlencode($quoteText);
        return <<<HTML
<!-- Preview: {$previewUrl} -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="article-title" content="{$title}">
    <meta name="article-seo-description" content="Навигация по сложности сопротивления изменениям и понимание того, как преодолеть сопротивление новым идеям и процессам.">
    <meta name="article-blog-section" content="Agile">
    <meta name="article-user-id" content="1">
    <meta name="article-main-image-path" content="/assets/img/basic_template_main_img.jpeg">
    <meta name="article-html-title" content="{$title}">
</head>
<body>
    <!-- Первый параграф статьи (отображается отдельно) -->
    <div class="first-paragraph">
        <p class="lead" style="margin-bottom: 48px;">Никто не любит, не ищет и не желает получить боль саму по себе, потому что это боль, но иногда возникают обстоятельства, когда труд и боль могут доставить ему большое удовольствие.</p>
    </div>
    
    <!-- Основной контент статьи -->
    <div class="content">
        <p>Но я должен объяснить вам, как родилась вся эта ошибочная идея обвинения удовольствия и восхваления боли, и я дам вам полный отчет о системе, излагая фактические учения великого исследователя истины, мастера-строителя человеческого счастья. Никто не отвергает, не любит, не избегает удовольствия как такового, потому что это удовольствие, но потому, что те, кто не умеет разумно преследовать удовольствие, сталкиваются с последствиями, которые чрезвычайно болезненны.</p>
        
        <p>Никто не любит боль саму по себе, не ищет её и не хочет её иметь, просто потому что это боль, но иногда возникают обстоятельства, когда труд и боль могут доставить ему большое удовольствие. Чтобы взять тривиальный пример, кто из нас когда-либо предпринимает физические упражнения, кроме как для получения от них какой-то пользы? Но кто имеет право порицать человека, который выбирает наслаждение, не вызывающее никаких последствий, или того, кто избегает боли, которая не приносит никакого удовольствия?</p>
        
        <h4>Заголовок для смены фокуса</h4>
        
        <p>С другой стороны, мы с негодованием осуждаем и с отвращением относимся к тем людям, которые настолько обольщены и деморализованы прелестями мгновенного удовольствия, настолько ослеплены желанием, что они не могут предвидеть боль и неприятности, которые неизбежно последуют; и равная вина лежит на тех, кто не выполняет свой долг из-за слабости воли, что то же самое, что сказать, из-за сокращения трудов и болей.</p>
        
        <figure>
            <img src="/assets/img/basic_template_img1.jpg" alt="Подпись к изображению" class="img-fluid rounded border">
            <figcaption>Подпись к изображению</figcaption>
        </figure>
        
        <p>Эти случаи совершенно просты и легко различимы. В свободный час, когда наша сила выбора ничем не ограничена и когда ничто не мешает нам делать то, что нам больше всего нравится, каждое удовольствие должно быть приветствовано и каждая боль избегаема.</p>
        
        <blockquote class="bg-primary-alt">
            <div class="h3 mb-2">&ldquo;Мы бы не справились без трудолюбивой команды из Leap.&rdquo;</div>
            <span class="text-small text-muted">– Харви Дент (через Тарека И.)</span>
            <a href="{$telegramShareUrl}" class="btn btn-primary btn-sm" target="_blank" rel="noopener noreferrer">
                <img class="icon" src="/assets/img/icons/social/telegram-plane-svgrepo-com.svg" alt="иконка telegram" data-inject-svg/>
                <span>Телеграмнуть</span>
            </a>
        </blockquote>
        
        <p>Но в определенных обстоятельствах и из-за требований долга или обязательств бизнеса часто случается, что обычные удовольствия должны быть отклонены и неприятности приняты. Мудрый человек поэтому всегда придерживается в этих вопросах принципа выбора: он отвергает удовольствия, чтобы обеспечить другие, большие удовольствия, или иначе терпит боли, чтобы избежать худших болей.</p>
        
        <h5>Небольшой заголовок для подведения итогов</h5>
        
        <p>Но я должен объяснить вам, как родилась вся эта ошибочная идея обвинения удовольствия и восхваления боли, и я дам вам полный отчет о системе, излагая фактические учения великого исследователя истины.</p>
        
        <ul>
            <li>Никто не любит боль саму по себе, не ищет её и не хочет её иметь</li>
            <li>Иногда возникают обстоятельства, когда труд и боль могут доставить удовольствие</li>
            <li>Мудрый человек всегда придерживается принципа выбора</li>
            <li>Он отвергает удовольствия, чтобы обеспечить другие, большие удовольствия</li>
        </ul>
    </div>
</body>
</html>
HTML;
    }

    /**
     * Шаблон Video - статья с видео
     */
    private function getVideoTemplate($title, $textUrl)
    {
        $previewUrl = "http://localhost:8000/drafts/{$textUrl}";
        return <<<HTML
<!-- Preview: {$previewUrl} -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="article-title" content="{$title}">
    <meta name="article-seo-description" content="Navigating the complexity of change aversion and understanding how to overcome resistance to new ideas and processes.">
    <meta name="article-blog-section" content="Agile">
    <meta name="article-user-id" content="1">
    <meta name="article-main-image-path" content="/assets/img/article_image.jpg">
    <meta name="article-html-title" content="{$title}">
</head>
<body>
    <!-- Первый параграф статьи (отображается отдельно) -->
    <div class="first-paragraph">
        <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
    </div>
    
    <!-- Основной контент статьи -->
    <div class="content">
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
        
        <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
        
        <h4>A heading to shift focus</h4>
        
        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.</p>
        
        <figure>
            <img src="/assets/img/article_image.jpg" alt="A caption to describe the image" class="img-fluid rounded border shadow-lg">
            <figcaption>A caption to describe the image</figcaption>
        </figure>
        
        <p>Aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
        
        <blockquote class="bg-primary-alt">
            <div class="h3 mb-2">&ldquo;We couldn't have done it without the hard-working team from Leap.&rdquo;</div>
            <span class="text-small text-muted">– Harvey Dent (via Tareq I.)</span>
            <a href="#" class="btn btn-primary btn-sm">
                <img class="icon" src="/assets/img/icons/social/twitter.svg" alt="twitter social icon" data-inject-svg/>
                <span>Tweet</span>
            </a>
        </blockquote>
        
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
        
        <h5>A minor heading to summarise</h5>
        
        <p>Sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur?</p>
        
        <ul>
            <li>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam</li>
            <li>Corporis suscipit laboriosam</li>
            <li>Aspernatur aut odit aut fugit eos qui ratione</li>
            <li>Et quasi</li>
        </ul>
    </div>
</body>
</html>
HTML;
    }

    /**
     * Шаблон Image Header - статья с большим изображением в заголовке
     */
    private function getImageHeaderTemplate($title, $textUrl)
    {
        $previewUrl = "http://localhost:8000/drafts/{$textUrl}";
        return <<<HTML
<!-- Preview: {$previewUrl} -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="article-title" content="{$title}">
    <meta name="article-seo-description" content="Navigating the complexity of change aversion and understanding how to overcome resistance to new ideas and processes.">
    <meta name="article-blog-section" content="Agile">
    <meta name="article-user-id" content="1">
    <meta name="article-main-image-path" content="/assets/img/article_image.jpg">
    <meta name="article-html-title" content="{$title}">
</head>
<body>
    <!-- Первый параграф статьи (отображается отдельно) -->
    <div class="first-paragraph">
        <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
    </div>
    
    <!-- Основной контент статьи -->
    <div class="content">
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
        
        <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
        
        <h4>A heading to shift focus</h4>
        
        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.</p>
        
        <figure>
            <img src="/assets/img/article_image.jpg" alt="A caption to describe the image" class="img-fluid rounded border shadow-lg">
            <figcaption>A caption to describe the image</figcaption>
        </figure>
        
        <p>Aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
        
        <blockquote class="bg-primary-alt">
            <div class="h3 mb-2">&ldquo;We couldn't have done it without the hard-working team from Leap.&rdquo;</div>
            <span class="text-small text-muted">– Harvey Dent (via Tareq I.)</span>
            <a href="#" class="btn btn-primary btn-sm">
                <img class="icon" src="/assets/img/icons/social/twitter.svg" alt="twitter social icon" data-inject-svg/>
                <span>Tweet</span>
            </a>
        </blockquote>
        
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
        
        <h5>A minor heading to summarise</h5>
        
        <p>Sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur?</p>
        
        <ul>
            <li>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam</li>
            <li>Corporis suscipit laboriosam</li>
            <li>Aspernatur aut odit aut fugit eos qui ratione</li>
            <li>Et quasi</li>
        </ul>
    </div>
</body>
</html>
HTML;
    }

    /**
     * Шаблон Parallax - статья с параллакс эффектом
     */
    private function getParallaxTemplate($title, $textUrl)
    {
        $previewUrl = "http://localhost:8000/drafts/{$textUrl}";
        return <<<HTML
<!-- Preview: {$previewUrl} -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="article-title" content="{$title}">
    <meta name="article-seo-description" content="Navigating the complexity of change aversion and understanding how to overcome resistance to new ideas and processes.">
    <meta name="article-blog-section" content="Agile">
    <meta name="article-user-id" content="1">
    <meta name="article-main-image-path" content="/assets/img/article_image.jpg">
    <meta name="article-html-title" content="{$title}">
</head>
<body>
    <!-- Первый параграф статьи (отображается отдельно) -->
    <div class="first-paragraph">
        <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
    </div>
    
    <!-- Основной контент статьи -->
    <div class="content">
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
        
        <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
        
        <h4>A heading to shift focus</h4>
        
        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.</p>
        
        <figure>
            <img src="/assets/img/article_image.jpg" alt="A caption to describe the image" class="img-fluid rounded border shadow-lg">
            <figcaption>A caption to describe the image</figcaption>
        </figure>
        
        <p>Aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
        
        <blockquote class="bg-primary-alt">
            <div class="h3 mb-2">&ldquo;We couldn't have done it without the hard-working team from Leap.&rdquo;</div>
            <span class="text-small text-muted">– Harvey Dent (via Tareq I.)</span>
            <a href="#" class="btn btn-primary btn-sm">
                <img class="icon" src="/assets/img/icons/social/twitter.svg" alt="twitter social icon" data-inject-svg/>
                <span>Tweet</span>
            </a>
        </blockquote>
        
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
        
        <h5>A minor heading to summarise</h5>
        
        <p>Sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur?</p>
        
        <ul>
            <li>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam</li>
            <li>Corporis suscipit laboriosam</li>
            <li>Aspernatur aut odit aut fugit eos qui ratione</li>
            <li>Et quasi</li>
        </ul>
    </div>
</body>
</html>
HTML;
    }

    /**
     * Создает черновик на основе опубликованной статьи
     *
     * @param Article $article
     * @param string $textUrl
     * @param string $templateType
     * @return string
     */
    private function createDraftFromPublishedArticle($article, $textUrl, $templateType)
    {
        $previewUrl = "http://localhost:8000/drafts/{$textUrl}";
        
        // Экранируем значения для HTML
        $title = htmlspecialchars($article->title, ENT_QUOTES, 'UTF-8');
        $seoDescription = htmlspecialchars($article->seo_description, ENT_QUOTES, 'UTF-8');
        $blogSection = htmlspecialchars($article->blog_section->title, ENT_QUOTES, 'UTF-8');
        $userId = $article->user_id;
        $mainImagePath = htmlspecialchars($article->main_image_path, ENT_QUOTES, 'UTF-8');
        $htmlTitle = htmlspecialchars($article->html_title, ENT_QUOTES, 'UTF-8');
        
        // Контент уже в HTML формате, просто используем как есть
        $firstParagraph = $article->first_paragraph;
        $content = $article->content;
        
        return <<<HTML
<!-- Preview: {$previewUrl} -->
<!-- Черновик создан на основе опубликованной статьи (ID: {$article->id}) -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="article-title" content="{$title}">
    <meta name="article-seo-description" content="{$seoDescription}">
    <meta name="article-blog-section" content="{$blogSection}">
    <meta name="article-user-id" content="{$userId}">
    <meta name="article-main-image-path" content="{$mainImagePath}">
    <meta name="article-html-title" content="{$htmlTitle}">
</head>
<body>
    <!-- Первый параграф статьи (отображается отдельно) -->
    <div class="first-paragraph">
        {$firstParagraph}
    </div>
    
    <!-- Основной контент статьи -->
    <div class="content">
        {$content}
    </div>
</body>
</html>
HTML;
    }
}

