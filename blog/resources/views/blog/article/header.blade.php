@php
    use App\Support\SiteLocale;

    $articleLayout = $article->getArticleLayout();
    $isHeroLayout = in_array($articleLayout, ['image-header', 'parallax'], true);
    $currentLocale = $site_locale ?? 'ru';
    $sectionTitle = trim((string) optional($article->blog_section)->title);
    $isAiSection = strcasecmp($sectionTitle, 'AI') === 0;
    $typedHeroTitle = trim(strip_tags((string) ($article->html_title ?: $article->title)));
    $heroSectionClass = $articleLayout === 'parallax'
        ? 'bg-dark text-light overlay min-vh-100 d-flex flex-column justify-content-end jarallax article-hero article-hero-parallax'
        : 'bg-dark text-light overlay min-vh-100 d-flex flex-column justify-content-end article-hero article-hero-image-header';
    $heroSectionClass .= $isAiSection ? ' article-hero--ai' : '';
    $blogRoute = SiteLocale::routeNameForLocale('blog.blog', $site_locale ?? 'ru');
    $sectionRoute = SiteLocale::routeNameForLocale('blog.show_blog_section', $site_locale ?? 'ru');
    $heroImagePositionByArticle = [
        'ai_i_scrum_events_chto_realno_menyaetsya_vo_vstrechah_komandy_razrabotki' => '28% 50%',
    ];
    $heroImagePosition = $heroImagePositionByArticle[$article->text_url] ?? '50% 50%';
@endphp

@if($isHeroLayout)
    <section class="{{ $heroSectionClass }}" @if($articleLayout === 'parallax') data-jarallax data-speed="0.5" data-img-position="{{ $heroImagePosition }}" @endif>
        @if($articleLayout === 'parallax')
            <img src="{{ $article->getHeroImagePath() }}" alt="{{ $article->title }}" class="jarallax-img opacity-60" style="object-position: {{ $heroImagePosition }};">
        @endif
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route($blogRoute) }}">{{ $locale_labels['blog'] }}</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route($sectionRoute, str_replace('/', '_SLASH_', $article->blog_section->title)) }}">{{ $article->blog_section->title }}</a>
                                </li>
                            </ol>
                        </nav>
                        <span class="article-hero-views" data-toggle="tooltip" data-placement="top" title data-original-title="{{ $locale_labels['unique_views'] ?? 'Количество уникальных просмотров' }}">
                            <img class="icon icon-sm mr-2"
                                 src="/assets/img/icons/theme/communication/group.svg"
                                 alt="views icon"
                                 data-inject-svg/>{!! $article->views_count !!}
                        </span>
                    </div>
                    @php $heroSeries = $article->seriesCard(); @endphp
                    @if($heroSeries)
                        <div class="article-hero-kicker" aria-label="{{ $currentLocale === 'en' ? 'Article series marker' : 'Маркер серии статей' }}">
                            <span>{{ $currentLocale === 'en' ? $heroSeries['label_en'] : $heroSeries['label_ru'] }}</span>
                            @if(in_array($article->text_url, config('blog.scrum_ai_series_slugs', []), true))
                                <span>{{ $currentLocale === 'en' ? 'Cross-functional team practice' : 'Практика кросс-функциональных команд' }}</span>
                            @endif
                        </div>
                    @endif
                    <h1>
                        <span class="sr-only">{{ $typedHeroTitle }}</span>
                        <span aria-hidden="true"
                              class="article-hero-typed-title"
                              data-typed-storage-key="article-hero-typed-seen:{{ $site_locale ?? 'ru' }}:{{ $article->id }}"
                              data-typed-final-text="{{ $typedHeroTitle }}"
                              data-typed-text
                              data-loop="false"
                              data-type-speed="24"
                              data-start-delay="250"
                              data-back-speed="0"
                              data-smart-backspace="false"
                              data-strings='@json([$typedHeroTitle])'></span>
                    </h1>
                    <script>
                        (function () {
                            var typedTitle = document.currentScript && document.currentScript.previousElementSibling
                                ? document.currentScript.previousElementSibling.querySelector('.article-hero-typed-title[data-typed-storage-key]')
                                : null;
                            if (!typedTitle) return;

                            var finalText = typedTitle.getAttribute('data-typed-final-text') || '';
                            var storageKey = typedTitle.getAttribute('data-typed-storage-key') || '';
                            var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                            var hasSeen = false;

                            try {
                                hasSeen = !!storageKey && window.sessionStorage.getItem(storageKey) === '1';
                            } catch (e) {}

                            if (reduceMotion || hasSeen) {
                                typedTitle.removeAttribute('data-typed-text');
                                typedTitle.textContent = finalText;
                                return;
                            }

                            try {
                                if (storageKey) {
                                    window.sessionStorage.setItem(storageKey, '1');
                                }
                            } catch (e) {}
                        })();
                    </script>
                    <div class="d-flex align-items-center">
                        <a href="#">
                            <img src="{{ config('app.url').$article->user->avatar_path }}" alt="Avatar" class="avatar mr-2">
                        </a>
                        <div>
                            <div>{{ $locale_labels['author_article'] ?? 'Автор статьи:' }} <a href="#">{{ $article->user->name }}</a></div>
                            <div class="text-small text-light-70">{{ $article->get_nice_time_created() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($articleLayout === 'image-header')
            <div class="container pb-5">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-xl-8">
                        <img src="{{ $article->getHeroImagePath() }}" alt="{{ $article->title }}" class="img-fluid rounded border shadow-lg">
                    </div>
                </div>
            </div>
        @endif
    </section>
@else
    @include('blog.article.breadcrumb_and_views', ['article' => $article])
@endif
