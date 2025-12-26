@extends('layouts.app')

@section('title', $article->title)
@section('description', $article->seo_description)
@section('page_url', route('blog.show_article', $article->text_url))
@section('main_image_path', url($article->main_image_path ?: '/assets/img/default-article-image.jpg'))

@section('custom_css')
    @parent
    <link href="/assets/css/custom.css?v={{ filemtime(public_path('assets/css/custom.css')) }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="/assets/css/custiom_article.css" rel="stylesheet" type="text/css" media="all"/>
    <style>
        .article figure {
            margin-top: 48px;
        }
    </style>
@endsection

@section('sidebar')
    @parent
@endsection

@section('content')
    @include('layouts.navbar_white', ['active_menu_item' => $active_menu_item])
    @include('blog.article.article_progress', ['article' => $article])
    @include('blog.article.breadcrumb_and_views', ['article' => $article])

    <section class="p-0" data-reading-position>
        <div class="container">
            <div class="row justify-content-center position-relative">
                <div class="col-lg-10 col-xl-8">
                    @if($article->isMainImageZoomEnabled())
                        <a href="{{ $article->main_image_path }}" data-fancybox="main-image" data-caption="{{ $article->title }}">
                            <img src="{{ $article->main_image_path }}" alt="{{ $article->title }}" class="img-fluid rounded">
                        </a>
                    @else
                        <img src="{{ $article->main_image_path }}" alt="{{ $article->title }}" class="img-fluid rounded">
                    @endif
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">
                    <article class="article">
                        {!! $article->first_paragraph !!}
                        {!! $article->content !!}
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="has-divider">
        <div class="container pt-3">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">

                    <hr>
                    @include('blog.article.social_sharing', ['article' => $article])
                    @include('blog.article.comments', ['article' => $article])
                    @include('blog.article.answer_form', ['article' => $article])
                    <hr id="add_comment">
                    @include('blog.article.add_comment', ['article' => $article])

                </div>
            </div>
        </div>
        <div class="divider">
            <img class="bg-primary-alt" src="/assets/img/dividers/divider-1.svg" alt="divider graphic" data-inject-svg/>
        </div>
    </section>

    @include('blog.article.related_stories', ['random_articles' => $random_articles])
    @include('blog.articles.emailing_list_footer')

@endsection

@section('pageScript')
    @parent
    @if(app()->environment('production'))
        <script type="text/javascript">
            (function () {
                var counterId = window.METRIKA_COUNTER_ID;
                if (!counterId || typeof ym !== 'function') return;

                var article = {
                    text_url: @json($article->text_url),
                    title: @json($article->title),
                    section: @json(optional($article->blog_section)->title),
                    confirmed: @json((int) $article->confirmed),
                };

                function reach(goal, params) {
                    try {
                        ym(counterId, 'reachGoal', goal, params || {});
                    } catch (e) {}
                }

                // 1) View
                reach('article_view', {article: article});

                // 2) Share clicks
                document.addEventListener('click', function (e) {
                    var a = e.target.closest ? e.target.closest('a[data-share-network]') : null;
                    if (!a) return;
                    reach('article_share_click', {
                        article: article,
                        network: a.getAttribute('data-share-network')
                    });
                }, true);

                // 3) Outbound link clicks (only inside article content)
                var articleEl = document.querySelector('article.article');
                if (articleEl) {
                    articleEl.addEventListener('click', function (e) {
                        var a = e.target.closest ? e.target.closest('a[href]') : null;
                        if (!a) return;
                        var href = a.getAttribute('href');
                        if (!href || href.indexOf('javascript:') === 0 || href.indexOf('#') === 0) return;

                        // Only external http(s)
                        if (href.indexOf('http://') !== 0 && href.indexOf('https://') !== 0) return;
                        try {
                            var u = new URL(href);
                            if (u.host === window.location.host) return;
                        } catch (err) {
                            return;
                        }

                        reach('article_outbound_click', {article: article, url: href});
                    }, true);
                }

                // 4) Comment submit
                document.addEventListener('submit', function (e) {
                    var form = e.target;
                    if (!form || !form.matches || !form.matches('form[data-metrika-comment-form]')) return;
                    reach('article_comment_submit', {article: article});
                }, true);

                // 5) Scroll depth (25/50/75/100)
                var fired = {25: false, 50: false, 75: false, 100: false};
                function onScroll() {
                    var doc = document.documentElement;
                    var scrollTop = window.pageYOffset || doc.scrollTop || 0;
                    var viewport = window.innerHeight || doc.clientHeight || 0;
                    var height = Math.max(doc.scrollHeight || 0, document.body.scrollHeight || 0);
                    var max = height - viewport;
                    if (max <= 0) return;
                    var pct = Math.min(100, Math.round((scrollTop / max) * 100));

                    if (!fired[25] && pct >= 25) { fired[25] = true; reach('article_scroll_25', {article: article}); }
                    if (!fired[50] && pct >= 50) { fired[50] = true; reach('article_scroll_50', {article: article}); }
                    if (!fired[75] && pct >= 75) { fired[75] = true; reach('article_scroll_75', {article: article}); }
                    if (!fired[100] && pct >= 95) { fired[100] = true; reach('article_scroll_100', {article: article}); }
                }

                var ticking = false;
                window.addEventListener('scroll', function () {
                    if (ticking) return;
                    ticking = true;
                    window.requestAnimationFrame(function () {
                        onScroll();
                        ticking = false;
                    });
                }, {passive: true});
                onScroll();
            })();
        </script>
    @endif
@endsection
