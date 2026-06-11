@php
    use App\Support\SiteLocale;

    $currentLocale = $site_locale ?? 'ru';
    $articleRoute = SiteLocale::routeNameForLocale('blog.show_article', $currentLocale);
    $sectionRoute = SiteLocale::routeNameForLocale('blog.show_blog_section', $currentLocale);
    $blogRoute = SiteLocale::routeNameForLocale('blog.blog', $currentLocale);
    $blogRuUrl = route('blog.blog');
    $blogEnUrl = route('en.blog.blog');
    $locale_switch_urls = [
        'ru' => $blogRuUrl,
        'en' => $blogEnUrl,
    ];
    $copy = $currentLocale === 'en'
        ? [
            'title' => 'Blog',
            'description' => 'Articles about product delivery, Agile, AI, and hands-on management practice.',
            'links' => 'Links',
            'views' => 'Unique views',
        ]
        : [
            'title' => 'Блог',
            'description' => 'Статьи про Agile, AI, delivery и практику управления командами.',
            'links' => 'Ссылки',
            'views' => 'Количество уникальных просмотров',
        ];
    $blogCanonicalUrl = ($currentLocale === 'en' && ($hasEnglishFallbackContent ?? false)) ? $blogRuUrl : route($blogRoute);
    $blogAlternateEnUrl = ($hasEnglishFallbackContent ?? false) ? '' : $blogEnUrl;
@endphp

<!-- Stored in resources/views/child.blade.php -->

@extends('layouts.app')

@section('title', $copy['title'])
@section('description', $copy['description'])
@section('page_url', route($blogRoute))
@section('canonical_url', $blogCanonicalUrl)
@section('alternate_url_ru', $blogRuUrl)
@section('alternate_url_en', $blogAlternateEnUrl)
@section('x_default_url', $blogEnUrl)
@section('meta_robots', ($currentLocale === 'en' && ($hasEnglishFallbackContent ?? false)) ? 'noindex,follow' : '')

@section('custom_css')
    @parent
    <link href="/assets/css/custom.css?v={{ filemtime(public_path('assets/css/custom.css')) }}" rel="stylesheet" type="text/css" media="all"/>
@endsection

@section('sidebar')
    @parent
    {{--    <p>This is appended to the master sidebar.</p>--}}
@endsection
@section('content')
    @include('layouts.navbar_white')
    @include('blog.articles.index_head')
    <section class="blog-index-list-section" data-overlay>
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-8 col-lg-9">
                    @foreach($groupedArticles as $section)
                        <div class="mb-5">
                            @if($section['title'])
                                <h2 class="mb-4">{{ $section['title'] }}</h2>
                            @endif
                            @foreach($section['articles'] as $item)
                                @switch($item->type_article)
                                    @case('article')
                                    @php
                                        $itemSectionTitle = trim((string) optional($item->blog_section)->title);
                                        $itemIsAi = strcasecmp($itemSectionTitle, 'AI') === 0;
                                        $itemSeriesLabel = $currentLocale === 'en' ? 'AI field notes' : 'AI-практика';
                                    @endphp
                                    <div class="pr-lg-4 mb-4">
                                        <div class="card card-article-wide article-card-clickable flex-md-row no-gutters {{ $itemIsAi ? 'card-article--ai' : '' }}">
                                            <a href="{{ route($articleRoute, $item->getRouteTextUrl($site_locale ?? 'ru')) }}" class="col-md-4">
                                                <img src="{{$item->getPreviewImagePath()}}" alt="Image" class="card-img-top">
                                            </a>
                                            <div class="card-body d-flex flex-column col-auto p-4">
                                                @if($itemIsAi)
                                                    <div class="article-card-series-badge">{{ $itemSeriesLabel }}</div>
                                                @endif
                                                <div class="d-flex justify-content-between mb-3">
                                                    <div class="text-small d-flex article-card-meta">
                                                        <div class="mr-2">
                                                            <a href="{{ route($sectionRoute, str_replace('/', '_SLASH_', $item->blog_section->title)) }}">{{$item->blog_section->short_title_for_display}}</a>
                                                        </div>
                                                        <span class="text-muted">{{$item->get_nice_day_created()}}</span>
                                                    </div>
                                                    <span class="badge bg-primary-alt text-primary" data-toggle="tooltip" data-placement="top"
                                                          title
                                                          data-original-title="{{ $copy['views'] }}">
                                          <img class="icon icon-sm bg-primary mr-1 view-count-icon"
                                               src="/assets/img/icons/theme/communication/group.svg"
                                               alt="visible icon"
                                               data-inject-svg/>{{$item->views_count}}
                                        </span>
                                                </div>
                                                <a href="{{ route($articleRoute, $item->getRouteTextUrl($site_locale ?? 'ru')) }}" class="flex-grow-1 article-card-main-link stretched-link">
                                                    <h3>{!!$item->html_title!!}</h3>
                                                </a>
                                                <div class="d-flex align-items-center mt-3">
                                                    <img src="{{config('app.url').$item->user->avatar_path}}" alt="Image"
                                                         class="avatar avatar-sm">
                                                    <div class="ml-1">
                                                        <span class="text-small">{{$item->user->name}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                    @case('link')
                                    <div class="pr-lg-4 mb-4">
                                        <noindex><a rel="nofollow noopener noreferrer" target="_blank" href="{{$item->text_url}}"
                                                    class="card card-body justify-content-between bg-primary text-light">
                                                <div class="d-flex justify-content-between mb-3">
                                                    <div class="text-small d-flex">
                                                        <div class="mr-2">
                                                            {{ $copy['links'] }}
                                                        </div>
                                                        <span class="opacity-70">{{$item->get_nice_day_created()}}</span>
                                                    </div>
                                                    <span class="badge bg-primary-alt text-primary" data-toggle="tooltip" data-placement="top"
                                                          title
                                                          data-original-title="{{ $copy['views'] }}">
                                                <img class="icon icon-sm bg-primary mr-1 view-count-icon"
                                                     src="/assets/img/icons/theme/communication/group.svg"
                                                     alt="visible icon"
                                                     data-inject-svg/>{{$item->views_count}}
                                            </span>
                                                </div>
                                                <div>
                                                    <h2>{!!$item->html_title!!}</h2>
                                                    <span class="text-small opacity-70">{{ \Illuminate\Support\Str::limit($item->text_url, config('blog.link_url_limit', 50)) }}</span>
                                                </div>
                                            </a></noindex>
                                    </div>
                                    @break
                                @endswitch
                            @endforeach
                        </div>
                    @endforeach
                </div>
                <div class="col-md-4 col-lg-3 d-none d-md-block">
                    @include('blog.articles.mailing_lists')
{{--                    @include('blog.articles.popular')--}}
                    @include('blog.articles.advertising')
                </div>
            </div>
        </div>
    </section>
    @include('blog.articles.emailing_list_footer')
@endsection
@section('pageScript')
    @parent
@endsection
