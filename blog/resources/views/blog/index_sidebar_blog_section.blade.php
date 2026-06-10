@php
    use App\Support\SiteLocale;

    $currentLocale = $site_locale ?? 'ru';
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
            'description' => 'Articles from this section. English pages fall back to Russian content when a translation is not ready yet.',
        ]
        : [
            'blog' => 'Блог',
            'description' => 'Статьи из выбранного раздела блога.',
        ];
    $sectionCanonicalUrl = ($currentLocale === 'en' && ($hasEnglishFallbackContent ?? false)) ? $sectionRuUrl : $sectionPageUrl;
    $sectionAlternateEnUrl = ($hasEnglishFallbackContent ?? false) ? '' : $sectionEnUrl;
@endphp

<!-- Stored in resources/views/child.blade.php -->

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
    {{--    <p>This is appended to the master sidebar.</p>--}}
@endsection



@section('content')
    @include('layouts.navbar_white', ['active_menu_item' => $active_menu_item])
{{--    @include('blog.articles.index_head')--}}

    <section data-overlay>
        <div class="container">
            <h1 class="blog-section-page-title">{{$blog_section->title}}</h1><br/>
            <div class="row mb-4">
                @include('blog.articles.list_items')
                <div class="col-md-4 col-lg-3 d-none d-md-block">
                    @include('blog.articles.mailing_lists')
                    {{--                    @include('blog.articles.popular')--}}
                    @include('blog.articles.advertising')
                </div>
            </div>
            {!! $items->links('blog.articles.pagination') !!}
        </div>
    </section>
    @include('blog.articles.emailing_list_footer')
@endsection
@section('pageScript')
    @parent
@endsection
