@php
    use App\Support\SiteLocale;

    $currentLocale = $site_locale ?? 'ru';
    $articleRoute = SiteLocale::routeNameForLocale('blog.show_article', $currentLocale);
    $sectionRoute = SiteLocale::routeNameForLocale('blog.show_blog_section', $currentLocale);
    $currentSectionSlug = str_replace('/', '_SLASH_', $blog_section->title);
    $sectionPageUrl = route($sectionRoute, $currentSectionSlug);
    $sectionRuUrl = route('blog.show_blog_section', $currentSectionSlug);
    $sectionEnUrl = route('en.blog.show_blog_section', $currentSectionSlug);
    $locale_switch_urls = [
        'ru' => $sectionRuUrl,
        'en' => $sectionEnUrl,
    ];
    $copy = $currentLocale === 'en'
        ? [
            'blog' => 'Blog',
            'views' => 'Unique views',
            'description' => 'Articles from this section. English pages fall back to Russian content when a translation is not ready yet.',
        ]
        : [
            'blog' => 'Блог',
            'views' => 'Количество уникальных просмотров',
            'description' => 'Статьи из выбранного раздела блога.',
        ];
    $sectionCanonicalUrl = ($currentLocale === 'en' && ($hasEnglishFallbackContent ?? false)) ? $sectionRuUrl : $sectionPageUrl;
    $sectionAlternateEnUrl = ($hasEnglishFallbackContent ?? false) ? '' : $sectionEnUrl;
@endphp

@extends('layouts.app')

@section('title', $blog_section->title . ' | ' . $copy['blog'])
@section('description', $copy['description'])
@section('page_url', $sectionPageUrl)
@section('canonical_url', $sectionCanonicalUrl)
@section('alternate_url_ru', $sectionRuUrl)
@section('alternate_url_en', $sectionAlternateEnUrl)
@section('x_default_url', $sectionEnUrl)
@section('meta_robots', ($currentLocale === 'en' && ($hasEnglishFallbackContent ?? false)) ? 'noindex,follow' : '')

@section('custom_css')
    @parent
    <link href="/assets/css/custom.css?v={{ filemtime(public_path('assets/css/custom.css')) }}" rel="stylesheet" type="text/css" media="all"/>
@endsection

@section('sidebar')
    @parent
@endsection

@section('content')
    @include('layouts.navbar_white', ['active_menu_item' => $active_menu_item])
    @include('blog.articles.index_head')

    <section data-overlay>
        <div class="container">
            <div class="row mb-4">
                <div class="col">
                    <h1 class="h2 mb-4 blog-section-page-title">{{ $blog_section->title }}</h1>
                </div>
            </div>

            <div class="row blog-masonry-grid">
                <div class="col-12 col-md-6 col-lg-4 blog-masonry-sizer"></div>

                @foreach($items as $item)
                    @php
                        $itemSectionTitle = trim((string) optional($item->blog_section)->title);
                        $itemIsAi = strcasecmp($itemSectionTitle, 'AI') === 0;
                        $itemSeriesLabel = $currentLocale === 'en' ? 'AI field notes' : 'AI-практика';
                    @endphp
                    <div class="col-12 col-md-6 col-lg-4 mb-4 blog-masonry-item">
                        <div class="card card-article article-card-clickable {{ $itemIsAi ? 'card-article--ai' : '' }}">
                            <a href="{{ route($articleRoute, $item->getRouteTextUrl($site_locale ?? 'ru')) }}">
                                <img src="{{ $item->getPreviewImagePath() }}" alt="{{ $item->title }}" class="card-img-top" width="600" height="338" loading="lazy" decoding="async">
                            </a>
                            <div class="card-body">
                                @if($itemIsAi)
                                    <div class="article-card-series-badge">{{ $itemSeriesLabel }}</div>
                                @endif
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="text-small d-flex article-card-meta">
                                        <div class="mr-2">
                                            <a href="{{ route($sectionRoute, str_replace('/', '_SLASH_', $item->blog_section->title)) }}">
                                                {{ $item->blog_section->short_title_for_display }}
                                            </a>
                                        </div>
                                        <span class="text-muted">{{ $item->get_nice_day_created() }}</span>
                                    </div>
                                    <span class="badge bg-primary-alt text-primary"
                                          data-toggle="tooltip" data-placement="top"
                                          title data-original-title="{{ $copy['views'] }}">
                                        <img class="icon icon-sm bg-primary mr-1 view-count-icon" src="/assets/img/icons/theme/communication/group.svg"
                                             alt="" aria-hidden="true" data-inject-svg/>
                                        {{ $item->views_count }}
                                    </span>
                                </div>

                                <a href="{{ route($articleRoute, $item->getRouteTextUrl($site_locale ?? 'ru')) }}" class="d-block article-card-main-link stretched-link">
                                    <h3>{!! $item->html_title !!}</h3>
                                </a>

                                @php
                                    $excerpt = trim(strip_tags($item->first_paragraph ?: $item->seo_description));
                                    $excerpt = \Illuminate\Support\Str::limit($excerpt, config('blog.excerpt_limit', 90), '..');
                                @endphp
                                @if($excerpt)
                                    <p class="mb-0 text-muted">{{ $excerpt }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {!! $items->links('blog.articles.pagination') !!}
        </div>
    </section>

    @include('blog.articles.emailing_list_footer')
@endsection

@section('pageScript')
    @parent
    <script type="text/javascript">
        window.addEventListener('load', function () {
            if (typeof Isotope === 'undefined') return;
            var grid = document.querySelector('.blog-masonry-grid');
            if (!grid) return;
            new Isotope(grid, {
                itemSelector: '.blog-masonry-item',
                percentPosition: true,
                masonry: {
                    columnWidth: '.blog-masonry-sizer'
                }
            });
        });
    </script>
@endsection
