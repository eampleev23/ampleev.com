@php
    use App\Support\SiteLocale;
    use Illuminate\Support\Str;

    $currentLocale = $blogLocale ?? ($site_locale ?? 'ru');
    $site_locale = $currentLocale;
    $articleRoute = SiteLocale::routeNameForLocale('blog.show_article', $currentLocale);
    $sectionRoute = SiteLocale::routeNameForLocale('blog.show_blog_section', $currentLocale);
    $blogRoute = SiteLocale::routeNameForLocale('blog.blog', $currentLocale);
    $blogRuUrl = route('blog.blog');
    $blogEnUrl = route('en.blog.blog');
    $locale_switch_urls = [
        'ru' => $blogRuUrl,
        'en' => $blogEnUrl,
    ];
    $labels = SiteLocale::labels($currentLocale);
    $copy = $currentLocale === SiteLocale::EN
        ? [
            'title' => 'Blog',
            'description' => 'Articles about product delivery, Agile, AI, and hands-on management practice.',
            'featured' => 'AI series',
            'recommended' => 'Recommended',
            'popular' => 'Popular',
            'categories' => 'Browse Categories',
            'latest' => 'Latest',
            'views' => 'Unique views',
            'recent_views' => 'views this week',
            'subscribe_title' => 'Get great articles direct to your inbox',
            'subscribe_note' => 'No noise. Only new articles and practical notes from the site.',
            'read_article' => 'Read article',
        ]
        : [
            'title' => 'Блог',
            'description' => 'Статьи про Agile, AI, delivery и практику управления командами.',
            'featured' => 'Серия про AI',
            'recommended' => 'Рекомендуемые',
            'popular' => 'Популярные',
            'categories' => 'Разделы',
            'latest' => 'Новые публикации',
            'views' => 'Количество уникальных просмотров',
            'recent_views' => 'просмотров за неделю',
            'subscribe_title' => 'Получайте оповещения о новых статьях прямо на свою электронную почту',
            'subscribe_note' => 'Без лишнего шума. Только новые публикации и практические заметки с сайта.',
            'read_article' => 'Читать статью',
        ];
    $blogCanonicalUrl = ($currentLocale === SiteLocale::EN && ($hasEnglishFallbackContent ?? false)) ? $blogRuUrl : route($blogRoute);
    $blogAlternateEnUrl = ($hasEnglishFallbackContent ?? false) ? '' : $blogEnUrl;
    $articleUrl = function ($article) use ($articleRoute, $currentLocale) {
        return route($articleRoute, $article->getRouteTextUrl($currentLocale));
    };
    $sectionUrl = function ($section) use ($sectionRoute) {
        return route($sectionRoute, str_replace('/', '_SLASH_', $section->title));
    };
    $excerpt = function ($article, $limit = 125) {
        return Str::limit(trim(strip_tags($article->first_paragraph ?: $article->seo_description)), $limit, '..');
    };
@endphp

@extends('layouts.app')

@section('title', $copy['title'])
@section('description', $copy['description'])
@section('page_url', route($blogRoute))
@section('canonical_url', $blogCanonicalUrl)
@section('alternate_url_ru', $blogRuUrl)
@section('alternate_url_en', $blogAlternateEnUrl)
@section('x_default_url', $blogEnUrl)
@section('meta_robots', ($currentLocale === SiteLocale::EN && ($hasEnglishFallbackContent ?? false)) ? 'noindex,follow' : '')

@section('custom_css')
    @parent
    <link href="/assets/css/custom.css?v={{ filemtime(public_path('assets/css/custom.css')) }}" rel="stylesheet" type="text/css" media="all"/>
@endsection

@section('content')
    @include('layouts.navbar_white', ['active_menu_item' => $active_menu_item])

    <section class="blog-magazine-hero pt-5 pb-4">
        <div class="container">
            <div class="row align-items-end mb-4">
                <div class="col-md-8">
                    <span class="text-primary font-weight-bold text-uppercase text-small">{{ $copy['featured'] }}</span>
                    <h1 class="display-4 mb-0">{{ $copy['title'] }}</h1>
                </div>
            </div>

            @if($aiArticles->isNotEmpty())
                <div class="blog-magazine-slider controls-inside arrows-inside"
                     data-flickity='{"wrapAround": true, "pageDots": true, "prevNextButtons": true, "adaptiveHeight": true}'>
                    @foreach($aiArticles as $article)
                        <article class="carousel-cell blog-magazine-slide">
                            <a href="{{ $articleUrl($article) }}" class="card blog-magazine-feature-card border-0 text-light o-hidden">
                                <img src="{{ $article->getPreviewImagePath() }}" alt="{{ strip_tags($article->title) }}" class="card-img">
                                <div class="card-img-overlay d-flex flex-column justify-content-end">
                                    <div class="blog-magazine-feature-copy">
                                        <div class="d-flex align-items-center text-small mb-2">
                                            <span>{{ $article->blog_section->short_title_for_display }}</span>
                                            <span class="mx-2 opacity-70">/</span>
                                            <span class="opacity-70">{{ $article->get_nice_day_created() }}</span>
                                        </div>
                                        <h2 class="display-4 mb-3">{!! $article->html_title !!}</h2>
                                        @if($excerpt($article, 150))
                                            <p class="lead mb-4">{{ $excerpt($article, 150) }}</p>
                                        @endif
                                        <span class="btn btn-white">{{ $copy['read_article'] }}</span>
                                    </div>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="pt-4 pb-0 blog-magazine-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    @if($recommendedArticles->isNotEmpty())
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h2 class="h3 mb-0">{{ $copy['recommended'] }}</h2>
                        </div>
                        <div class="row">
                            @foreach($recommendedArticles as $article)
                                <div class="col-md-6 mb-4">
                                    <article class="card card-article blog-magazine-card h-100">
                                        <a href="{{ $articleUrl($article) }}">
                                            <img src="{{ $article->getPreviewImagePath() }}" alt="{{ strip_tags($article->title) }}" class="card-img-top">
                                        </a>
                                        <div class="card-body d-flex flex-column">
                                            <div class="d-flex justify-content-between mb-3 text-small">
                                                <a href="{{ $sectionUrl($article->blog_section) }}">{{ $article->blog_section->short_title_for_display }}</a>
                                                <span class="text-muted">{{ $article->get_nice_day_created() }}</span>
                                            </div>
                                            <a href="{{ $articleUrl($article) }}" class="d-block">
                                                <h3 class="h4">{!! $article->html_title !!}</h3>
                                            </a>
                                            @if($excerpt($article))
                                                <p class="text-muted mb-0">{{ $excerpt($article) }}</p>
                                            @endif
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <aside class="col-lg-4">
                    @if($popularArticles->isNotEmpty())
                        <div class="blog-magazine-sidebar-block mb-5">
                            <h2 class="h5 mb-4">{{ $copy['popular'] }}</h2>
                            <ul class="list-unstyled list-articles mb-0">
                                @foreach($popularArticles as $article)
                                    <li class="row row-tight mb-4">
                                        <a href="{{ $articleUrl($article) }}" class="col-3">
                                            <img src="{{ $article->getPreviewImagePath() }}" alt="{{ strip_tags($article->title) }}" class="rounded">
                                        </a>
                                        <div class="col">
                                            <a href="{{ $articleUrl($article) }}">
                                                <h3 class="h6 mb-1">{!! $article->html_title !!}</h3>
                                            </a>
                                            <div class="text-small text-muted">
                                                {{ $article->recent_views_count }} {{ $copy['recent_views'] }}
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($blogSections->isNotEmpty())
                        <div class="blog-magazine-sidebar-block mb-5">
                            <h2 class="h5 mb-4">{{ $copy['categories'] }}</h2>
                            <ul class="list-unstyled mb-0">
                                @foreach($blogSections as $section)
                                    <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                        <a href="{{ $sectionUrl($section) }}">{{ $section->title }}</a>
                                        <span class="badge bg-primary-alt text-primary">{{ $section->published_articles_count }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </aside>
            </div>
        </div>
    </section>

    @if($latestArticles->isNotEmpty())
        <section class="pt-4 pb-0 blog-magazine-latest">
            <div class="container">
                <h2 class="h3 mb-4">{{ $copy['latest'] }}</h2>
                <div class="row">
                    @foreach($latestArticles as $article)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <article class="card card-article blog-magazine-card h-100">
                                <a href="{{ $articleUrl($article) }}">
                                    <img src="{{ $article->getPreviewImagePath() }}" alt="{{ strip_tags($article->title) }}" class="card-img-top">
                                </a>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-3 text-small">
                                        <a href="{{ $sectionUrl($article->blog_section) }}">{{ $article->blog_section->short_title_for_display }}</a>
                                        <span class="text-muted">{{ $article->get_nice_day_created() }}</span>
                                    </div>
                                    <a href="{{ $articleUrl($article) }}">
                                        <h3 class="h4 mb-0">{!! $article->html_title !!}</h3>
                                    </a>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="blog-magazine-subscribe py-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-xl-7 col-lg-8 col-md-10">
                    <h2 class="h3 mb-3">{{ $copy['subscribe_title'] }}</h2>
                    <p class="text-muted mb-4">{{ $copy['subscribe_note'] }}</p>
                    <form action="{{ route(SiteLocale::routeNameForLocale('blog.add_subscriber', $currentLocale)) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="d-none" aria-hidden="true">
                            <input type="text" name="company_name" value="" tabindex="-1" autocomplete="off">
                        </div>
                        <div class="d-sm-flex flex-column flex-sm-row mb-3 justify-content-center">
                            <input type="email" name="email" class="mr-sm-1 mb-2 mb-sm-0 form-control form-control-lg" placeholder="{{ $labels['subscribe_placeholder'] }}" required>
                            <div data-recaptcha data-sitekey="INSERT_YOUR_RECAPTCHA_V2_SITEKEY_HERE" data-size="invisible" data-badge="bottomleft"></div>
                            <button type="submit" class="ml-sm-1 btn btn-lg btn-primary btn-loading" data-loading-text="Sending">
                                <img class="icon" src="/assets/img/icons/theme/code/loading.svg" alt="loading icon" data-inject-svg/>
                                <span>{{ $labels['subscribe'] }}</span>
                            </button>
                        </div>
                        <div>
                            <div class="d-none alert alert-success" role="alert" data-success-message>
                                {{ $labels['subscribe_success'] }}
                            </div>
                            <div class="d-none alert alert-danger" role="alert" data-error-message>
                                {{ $labels['subscribe_error'] }}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('pageScript')
    @parent
@endsection
