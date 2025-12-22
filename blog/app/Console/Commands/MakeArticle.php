<?php

namespace App\Console\Commands;

use App\Helpers\Transliterator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeArticle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:article {title : Название статьи (text_url будет сгенерирован автоматически)} {--template=basic : Шаблон статьи (basic, video, image-header, parallax)}';

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
        $validTemplates = ['basic', 'video', 'image-header', 'parallax'];
        if (!in_array($templateType, $validTemplates)) {
            $this->error("Неверный шаблон. Доступные шаблоны: " . implode(', ', $validTemplates));
            return 1;
        }

        // Проверяем, существует ли файл
        if (File::exists($draftPath)) {
            $this->error("Файл черновика уже существует: {$filename}");
            return 1;
        }

        // Создаем шаблон HTML
        $template = $this->getTemplate($title, $textUrl, $templateType);

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
    private function getTemplate($title, $textUrl, $templateType = 'basic')
    {
        switch ($templateType) {
            case 'basic':
                return $this->getBasicTemplate($title, $textUrl);
            case 'video':
                return $this->getVideoTemplate($title, $textUrl);
            case 'image-header':
                return $this->getImageHeaderTemplate($title, $textUrl);
            case 'parallax':
                return $this->getParallaxTemplate($title, $textUrl);
            default:
                return $this->getBasicTemplate($title, $textUrl);
        }
    }

    /**
     * Шаблон Basic - обычная статья с изображением
     */
    private function getBasicTemplate($title, $textUrl)
    {
        return <<<HTML
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
            <div class="h3 mb-2">"We couldn't have done it without the hard-working team from Leap."</div>
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
     * Шаблон Video - статья с видео
     */
    private function getVideoTemplate($title, $textUrl)
    {
        return <<<HTML
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
            <div class="h3 mb-2">"We couldn't have done it without the hard-working team from Leap."</div>
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
        return <<<HTML
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
            <div class="h3 mb-2">"We couldn't have done it without the hard-working team from Leap."</div>
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
        return <<<HTML
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
            <div class="h3 mb-2">"We couldn't have done it without the hard-working team from Leap."</div>
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
}

