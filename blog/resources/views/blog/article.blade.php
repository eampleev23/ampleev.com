@php
    use App\Support\SiteLocale;

    $currentLocale = $site_locale ?? 'ru';
    $articleRoute = SiteLocale::routeNameForLocale('blog.show_article', $currentLocale);
    $articleRuUrl = route('blog.show_article', $article->getRouteTextUrl('ru'));
    $articleEnTranslation = $article->translation('en');
    $articleEnUrl = $articleEnTranslation ? route('en.blog.show_article', $article->getRouteTextUrl('en')) : '';
    $articleCanonicalUrl = ($currentLocale === 'en' && !$articleEnTranslation) ? $articleRuUrl : route($articleRoute, $article->getRouteTextUrl($currentLocale));
    $articleMetaRobots = ($currentLocale === 'en' && !$articleEnTranslation) ? 'noindex,follow' : '';
    $articleXDefaultUrl = $articleEnTranslation ? $articleEnUrl : $articleRuUrl;
    $locale_switch_urls = [
        'ru' => $articleRuUrl,
        'en' => $articleEnTranslation ? $articleEnUrl : route('en.blog.show_article', $article->getRouteTextUrl('ru')),
    ];
@endphp

@extends('layouts.app')

@section('title', $article->title)
@section('description', $article->seo_description)
@section('page_url', route($articleRoute, $article->getRouteTextUrl($currentLocale)))
@section('canonical_url', $articleCanonicalUrl)
@section('alternate_url_ru', $articleRuUrl)
@section('alternate_url_en', $articleEnUrl)
@section('x_default_url', $articleXDefaultUrl)
@section('meta_robots', $articleMetaRobots)
@section('main_image_path', url($article->main_image_path ?: '/assets/img/default-article-image.jpg'))

@section('custom_css')
    @parent
    <link href="/assets/css/custom.css?v={{ filemtime(public_path('assets/css/custom.css')) }}" rel="stylesheet" type="text/css" media="all"/>
    <link href="/assets/css/custiom_article.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="/assets/css/prism.css" rel="stylesheet" type="text/css" media="all"/>
    <style>
        .article figure {
            margin-top: 48px;
        }
        .article-hero {
            position: relative;
            overflow: hidden;
        }
        .article-hero .container {
            position: relative;
            z-index: 1;
            padding-top: 6rem;
            padding-bottom: 4rem;
        }
        .article-hero h1 {
            font-size: clamp(2rem, 4vw, 3.75rem);
            line-height: 1.1;
        }
        .article-hero .breadcrumb a,
        .article-hero .breadcrumb-item.active,
        .article-hero .breadcrumb-item + .breadcrumb-item::before {
            color: rgba(255, 255, 255, 0.85);
        }
        .article-hero-image-header::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(15, 23, 42, 0.72) 0%, rgba(15, 23, 42, 0.72) 100%),
                var(--article-hero-image) center/cover no-repeat;
        }
        .article-hero-views {
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: 0.01em;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }
        .article-hero-views .icon {
            width: 1.15rem;
            height: 1.15rem;
            flex: 0 0 auto;
        }
        .article-hero-views .icon path,
        .article-hero-views .icon circle,
        .article-hero-views .icon ellipse {
            fill: rgba(255, 255, 255, 0.95) !important;
            opacity: 1 !important;
        }
        .article-hero .text-light-70 {
            color: rgba(255, 255, 255, 0.7);
        }
        .article .table-responsive {
            overflow-x: visible;
        }
        .article .table {
            width: 100%;
            table-layout: fixed;
            font-size: 0.94rem;
        }
        .article .table th,
        .article .table td {
            white-space: normal;
            word-break: normal;
            overflow-wrap: normal;
            hyphens: none;
            vertical-align: top;
        }
        .article .table th:first-child,
        .article .table td:first-child {
            width: 24%;
        }
        .article .role-changes-table th:nth-child(1),
        .article .role-changes-table td:nth-child(1) {
            width: 20%;
        }
        .article .role-changes-table th:nth-child(2),
        .article .role-changes-table td:nth-child(2),
        .article .role-changes-table th:nth-child(3),
        .article .role-changes-table td:nth-child(3) {
            width: 40%;
        }
        .article .table .table-nowrap {
            display: inline-block;
            white-space: nowrap;
        }
        .article pre[class*="language-"],
        .article code[class*="language-"] {
            font-size: 0.75rem;
            line-height: 1.4;
        }
        .article pre[class*="language-"] {
            background: #fff;
            color: #212529;
            border: 1px solid rgba(27, 31, 59, 0.08);
            border-radius: 0.3125rem;
            padding: 1.25rem;
            box-shadow: none;
        }
        .article pre[class*="language-"] code[class*="language-"] {
            color: #212529;
            text-shadow: none;
            background: transparent;
        }
        .article pre[class*="language-"] .token,
        .article pre[class*="language-"] .token.comment,
        .article pre[class*="language-"] .token.keyword,
        .article pre[class*="language-"] .token.string,
        .article pre[class*="language-"] .token.number,
        .article pre[class*="language-"] .token.function,
        .article pre[class*="language-"] .token.operator,
        .article pre[class*="language-"] .token.builtin,
        .article pre[class*="language-"] .token.punctuation {
            color: #212529 !important;
        }
        .article-preview-popover-template {
            display: none;
        }
        .article .article-preview-link {
            text-decoration-thickness: 1px;
            text-underline-offset: 0.15em;
        }
        .popover.article-preview-popover {
            max-width: 22rem;
            border: none;
            font-weight: 400;
            background: transparent;
            box-shadow: none;
        }
        .popover.article-preview-popover .popover-body {
            padding: 0;
        }
        .article-preview-popover-card {
            border: 0;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 1rem 2.5rem rgba(27, 31, 59, 0.16);
        }
        .article-preview-popover-image {
            display: block;
        }
        .article-preview-popover-image img {
            display: block;
            width: 100%;
            height: auto;
        }
        .article-preview-popover-body {
            padding: 1.25rem;
        }
        .article-preview-popover-body .badge {
            white-space: nowrap;
        }
        .article-progress .article-progress-wrapper .btn[data-share-network] {
            margin-left: calc(0.25rem + 1px) !important;
            margin-right: 0 !important;
        }
        .article-progress .article-progress-wrapper .btn[data-share-network]:first-child {
            margin-left: 0 !important;
        }
        .article-progress .article-progress-wrapper .d-flex.align-items-center > .d-flex.ml-1 {
            margin-left: 0.25rem !important;
        }
        .article-progress .article-progress-share-label {
            position: relative;
            left: -2px;
        }
        @media (min-width: 992px) {
            .article-progress .article-progress-share {
                margin-right: 1.9rem;
            }
        }
        @media (min-width: 992px) {
            .article-main-column,
            .article-secondary-column {
                flex: 0 0 75%;
                max-width: 75%;
            }
        }
    </style>
@endsection

@section('sidebar')
    @parent
@endsection

@section('content')
    @php
        $firstParagraphHtml = (string) ($article->first_paragraph ?? '');
        $mainImagePath = (string) ($article->main_image_path ?? '');
        $hideLegacyMainImage = $article->getArticleLayout() === \App\Article::LAYOUT_CLASSIC
            && $mainImagePath !== ''
            && str_contains($firstParagraphHtml, 'popover-image')
            && str_contains($firstParagraphHtml, $mainImagePath);
    @endphp
    @if(in_array($article->getArticleLayout(), [\App\Article::LAYOUT_IMAGE_HEADER, \App\Article::LAYOUT_PARALLAX], true))
        @include('layouts.navbar', ['active_menu_item' => $active_menu_item])
    @else
        @include('layouts.navbar_white', ['active_menu_item' => $active_menu_item])
    @endif
    @include('blog.article.article_progress', ['article' => $article])
    <div style="--article-hero-image: url('{{ $article->getHeroImagePath() }}');">
        @include('blog.article.header', ['article' => $article])
    </div>

    <section class="p-0" data-reading-position>
        <div class="container">
            @if($article->getArticleLayout() === \App\Article::LAYOUT_CLASSIC && !$hideLegacyMainImage)
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
            @endif
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10 article-main-column">
                    <article class="article">
                        {!! $article->first_paragraph !!}
                        {!! $article->content !!}
                    </article>
                    @if(!empty($cursorExperienceArticle))
                        <div id="cursor-experience-popover" class="article-preview-popover-template" aria-hidden="true">
                            @include('blog.article.article_preview_popover_card', ['previewArticle' => $cursorExperienceArticle])
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="has-divider">
        <div class="container pt-3">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10 article-secondary-column">

                    <hr>
                    @include('blog.article.feedback_questions', ['article' => $article, 'articleFeedbackAnswers' => $articleFeedbackAnswers ?? collect()])
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
    <script type="text/javascript">
        (function () {
            if (typeof Prism === 'undefined') return;

            if (!Prism.languages.python) {
                Prism.languages.python = {
                    comment: {
                        pattern: /(^|[^\\])#.*/,
                        lookbehind: true,
                        greedy: true
                    },
                    'triple-quoted-string': {
                        pattern: /("""|''')[\s\S]+?\1/,
                        greedy: true,
                        alias: 'string'
                    },
                    string: {
                        pattern: /(["'])(?:\\.|(?!\1)[^\\\r\n])*\1/,
                        greedy: true
                    },
                    keyword: /\b(?:and|as|assert|async|await|break|class|continue|def|del|elif|else|except|False|finally|for|from|if|import|in|is|lambda|None|nonlocal|not|or|pass|raise|return|True|try|while|with|yield)\b/,
                    builtin: /\b(?:abs|all|any|bool|dict|enumerate|float|int|len|list|max|min|print|range|round|set|str|sum|tuple|zip)\b/,
                    function: /\b[a-zA-Z_]\w*(?=\()/,
                    number: /\b(?:0b[01_]+|0o[0-7_]+|0x[\da-fA-F_]+|\d+(?:\.\d+)?(?:e[+-]?\d+)?)\b/,
                    operator: /[-+%=]=?|!=|<=?|>=?|\*\*?|\/\/?|->|[&|^~]/,
                    punctuation: /[{}[\];(),.:]/
                };
            }

            Prism.highlightAll();
        })();
    </script>
    <script type="text/javascript">
        (function () {
            var typedTitle = document.querySelector('.article-hero-typed-title[data-typed-final-text]');
            if (!typedTitle) return;

            var expectedText = typedTitle.getAttribute('data-typed-final-text') || '';
            var attempts = 0;
            var maxAttempts = 200;
            var timer = window.setInterval(function () {
                attempts += 1;

                var currentText = (typedTitle.textContent || '').trim();
                var cursor = typedTitle.parentNode ? typedTitle.parentNode.querySelector('.typed-cursor') : null;

                if (currentText === expectedText) {
                    if (cursor) {
                        cursor.style.display = 'none';
                    }
                    window.clearInterval(timer);
                    return;
                }

                if (attempts >= maxAttempts) {
                    window.clearInterval(timer);
                }
            }, 80);
        })();
    </script>
    <script type="text/javascript">
        (function () {
            if (typeof jQuery === 'undefined' || typeof jQuery.fn.popover !== 'function') return;

            var $ = jQuery;

            $('[data-article-preview-popover]').each(function () {
                var $trigger = $(this);
                var templateId = $trigger.attr('data-article-preview-popover');
                var template = document.getElementById(templateId);

                if (!template) return;

                $trigger.addClass('article-preview-link');
                $trigger.popover({
                    trigger: 'manual',
                    html: true,
                    sanitize: false,
                    container: 'body',
                    placement: 'top',
                    template: '<div class="popover article-preview-popover" role="tooltip"><div class="arrow"></div><div class="popover-body"></div></div>',
                    content: function () {
                        return template.innerHTML;
                    }
                });

                var hideTimer = null;

                function getPopoverElement() {
                    var popoverId = $trigger.attr('aria-describedby');
                    return popoverId ? document.getElementById(popoverId) : null;
                }

                function clearHideTimer() {
                    if (!hideTimer) return;
                    window.clearTimeout(hideTimer);
                    hideTimer = null;
                }

                function scheduleHide() {
                    clearHideTimer();
                    hideTimer = window.setTimeout(function () {
                        $trigger.popover('hide');
                    }, 140);
                }

                function bindPopoverHover() {
                    var popover = getPopoverElement();
                    if (!popover) return;

                    $(popover)
                        .off('.articlePreviewPopover')
                        .on('mouseenter.articlePreviewPopover focusin.articlePreviewPopover', function () {
                            clearHideTimer();
                        })
                        .on('mouseleave.articlePreviewPopover focusout.articlePreviewPopover', function () {
                            scheduleHide();
                        });
                }

                function showPopover() {
                    clearHideTimer();
                    $trigger.popover('show');
                    bindPopoverHover();
                }

                $trigger
                    .on('mouseenter.articlePreviewPopover focusin.articlePreviewPopover', function () {
                        showPopover();
                    })
                    .on('mouseleave.articlePreviewPopover focusout.articlePreviewPopover', function () {
                        scheduleHide();
                    });
            });
        })();
    </script>
    @php
        $articleAnalyticsQuery = request()->query('metrika');
        $articleAnalyticsDisabled = $articleAnalyticsQuery === 'off'
            || ($articleAnalyticsQuery !== 'on' && request()->cookie('metrika_disabled') === '1')
            || (auth()->check() && auth()->user()->is_admin)
            || request()->is(
                'drafts*',
                'confirm_subscriber*',
                'confirm-subscriber*',
                'en/drafts*',
                'en/confirm_subscriber*',
                'en/confirm-subscriber*'
            );
        $articleReadAnalyticsRoute = route(SiteLocale::routeNameForLocale('blog.article_read_analytics_store', $currentLocale));
    @endphp
    @if(app()->environment('production') && !$articleAnalyticsDisabled)
        <script type="text/javascript">
            (function () {
                var articleEl = document.querySelector('article.article');
                if (!articleEl || !window.fetch) return;

                var endpoint = @json($articleReadAnalyticsRoute);
                var csrfToken = @json(csrf_token());
                var sessionKey = createSessionKey();
                var state = {
                    maxScrollPercent: 0,
                    activeSeconds: 0,
                    reached25: false,
                    reached50: false,
                    reached75: false,
                    reached100: false
                };
                var sent = {
                    maxScrollPercent: -1,
                    activeSeconds: -1,
                    reached25: false,
                    reached50: false,
                    reached75: false,
                    reached100: false
                };
                var visibleSince = document.visibilityState === 'visible' ? Date.now() : null;
                var ticking = false;
                var flushTimer = null;

                function createSessionKey() {
                    if (window.crypto && typeof window.crypto.randomUUID === 'function') {
                        return window.crypto.randomUUID();
                    }

                    return 'ars-' + Date.now().toString(36) + '-' + Math.random().toString(36).slice(2);
                }

                function clamp(value, min, max) {
                    return Math.max(min, Math.min(max, value));
                }

                function updateActiveTime() {
                    if (document.visibilityState !== 'visible') {
                        if (visibleSince) {
                            state.activeSeconds += Math.max(0, Math.round((Date.now() - visibleSince) / 1000));
                        }
                        visibleSince = null;
                        return;
                    }

                    if (!visibleSince) {
                        visibleSince = Date.now();
                        return;
                    }

                    var now = Date.now();
                    state.activeSeconds += Math.max(0, Math.round((now - visibleSince) / 1000));
                    visibleSince = now;
                }

                function calculateArticlePercent() {
                    var rect = articleEl.getBoundingClientRect();
                    var articleTop = window.pageYOffset + rect.top;
                    var articleHeight = Math.max(articleEl.scrollHeight || 0, rect.height || 0);
                    if (articleHeight <= 0) return 0;

                    var viewportBottom = window.pageYOffset + (window.innerHeight || document.documentElement.clientHeight || 0);
                    var percent = ((viewportBottom - articleTop) / articleHeight) * 100;

                    return clamp(Math.round(percent), 0, 100);
                }

                function updateScrollState() {
                    var percent = calculateArticlePercent();
                    state.maxScrollPercent = Math.max(state.maxScrollPercent, percent);
                    state.reached25 = state.reached25 || state.maxScrollPercent >= 25;
                    state.reached50 = state.reached50 || state.maxScrollPercent >= 50;
                    state.reached75 = state.reached75 || state.maxScrollPercent >= 75;
                    state.reached100 = state.reached100 || state.maxScrollPercent >= 95;
                }

                function shouldFlush(force) {
                    if (force) return true;
                    if (state.reached25 && !sent.reached25) return true;
                    if (state.reached50 && !sent.reached50) return true;
                    if (state.reached75 && !sent.reached75) return true;
                    if (state.reached100 && !sent.reached100) return true;
                    if (state.maxScrollPercent - sent.maxScrollPercent >= 10) return true;
                    return state.activeSeconds - sent.activeSeconds >= 20;
                }

                function markSent() {
                    sent.maxScrollPercent = state.maxScrollPercent;
                    sent.activeSeconds = state.activeSeconds;
                    sent.reached25 = state.reached25;
                    sent.reached50 = state.reached50;
                    sent.reached75 = state.reached75;
                    sent.reached100 = state.reached100;
                }

                function payload() {
                    return {
                        _token: csrfToken,
                        article_id: @json($article->id),
                        session_key: sessionKey,
                        max_scroll_percent: state.maxScrollPercent,
                        active_seconds: state.activeSeconds,
                        reached_25: state.reached25,
                        reached_50: state.reached50,
                        reached_75: state.reached75,
                        reached_100: state.reached100,
                        viewport_width: window.innerWidth || document.documentElement.clientWidth || 0,
                        viewport_height: window.innerHeight || document.documentElement.clientHeight || 0,
                        screen_width: window.screen ? window.screen.width : 0,
                        screen_height: window.screen ? window.screen.height : 0,
                        url: window.location.href,
                        referer: document.referrer || ''
                    };
                }

                function flush(force) {
                    updateActiveTime();
                    updateScrollState();

                    if (!shouldFlush(force)) return;

                    window.fetch(endpoint, {
                        method: 'POST',
                        keepalive: !!force,
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(payload())
                    }).then(function (response) {
                        if (response.ok) {
                            markSent();
                        }
                    }).catch(function () {});
                }

                function scheduleFlush() {
                    if (flushTimer) return;
                    flushTimer = window.setTimeout(function () {
                        flushTimer = null;
                        flush(false);
                    }, 1200);
                }

                window.addEventListener('scroll', function () {
                    if (ticking) return;
                    ticking = true;
                    window.requestAnimationFrame(function () {
                        updateScrollState();
                        scheduleFlush();
                        ticking = false;
                    });
                }, {passive: true});

                window.addEventListener('resize', function () {
                    updateScrollState();
                    scheduleFlush();
                }, {passive: true});

                document.addEventListener('visibilitychange', function () {
                    if (document.visibilityState === 'hidden') {
                        flush(true);
                    } else {
                        visibleSince = Date.now();
                    }
                });

                window.addEventListener('pagehide', function () {
                    flush(true);
                });

                window.setInterval(function () {
                    flush(false);
                }, 15000);

                flush(true);
            })();
        </script>
    @endif
    @if(app()->environment('production'))
        <script type="text/javascript">
            (function () {
                var counterId = window.METRIKA_COUNTER_ID;
                var hasMetrika = counterId && typeof ym === 'function';
                var hasGoogleAnalytics = typeof window.gtag === 'function';
                if (!hasMetrika && !hasGoogleAnalytics) return;

                var article = {
                    text_url: @json($article->text_url),
                    title: @json($article->title),
                    section: @json(optional($article->blog_section)->title),
                    confirmed: @json((int) $article->confirmed),
                };

                function reach(goal, params) {
                    params = params || {};

                    try {
                        if (hasMetrika) {
                            ym(counterId, 'reachGoal', goal, Object.assign({article: article}, params));
                        }
                    } catch (e) {}

                    try {
                        if (hasGoogleAnalytics) {
                            window.gtag('event', goal, Object.assign({
                                article_text_url: article.text_url,
                                article_title: article.title,
                                article_section: article.section || '',
                                article_confirmed: article.confirmed
                            }, params));
                        }
                    } catch (e) {}
                }

                // 1) View
                reach('article_view');

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

                        reach('article_outbound_click', {url: href});
                    }, true);
                }

                // 4) Comment submit
                document.addEventListener('submit', function (e) {
                    var form = e.target;
                    if (!form || !form.matches || !form.matches('form[data-metrika-comment-form]')) return;
                    reach('article_comment_submit');
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

                    if (!fired[25] && pct >= 25) { fired[25] = true; reach('article_scroll_25', {scroll_percent: 25}); }
                    if (!fired[50] && pct >= 50) { fired[50] = true; reach('article_scroll_50', {scroll_percent: 50}); }
                    if (!fired[75] && pct >= 75) { fired[75] = true; reach('article_scroll_75', {scroll_percent: 75}); }
                    if (!fired[100] && pct >= 95) { fired[100] = true; reach('article_scroll_100', {scroll_percent: 100}); }
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
