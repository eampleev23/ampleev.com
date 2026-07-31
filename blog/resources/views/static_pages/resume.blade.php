@php
    use App\Support\SiteLocale;

    $currentLocale = SiteLocale::resolve(request());
    $copy = config('about.' . $currentLocale);
    $resumeRoute = SiteLocale::routeNameForLocale('static_pages.resume', $currentLocale);
    $resumeRuUrl = route('static_pages.resume');
    $resumeEnUrl = route('en.static_pages.resume');
    $locale_switch_urls = [
        'ru' => $resumeRuUrl,
        'en' => $resumeEnUrl,
    ];
    $resumeUrl = route('resume.pdf');
    $resumeDownloadUrl = route('resume.download');
    $portraitUrl = asset('assets/img/about-me/about-me-portrait.png');
    $localeTag = $currentLocale === 'en' ? 'en-US' : 'ru-RU';

    $hasAiUsageSnapshot = isset($aiUsageSnapshot) && $aiUsageSnapshot;
    $formatTokens = static fn (int $value): string => number_format($value, 0, ',', ' ');
    $aiTotalTokens = $hasAiUsageSnapshot ? (int) $aiUsageSnapshot->total_tokens : 0;
    $aiClaudeTokens = $hasAiUsageSnapshot ? (int) $aiUsageSnapshot->claude_tokens : 0;
    $aiCodexTokens = $hasAiUsageSnapshot ? (int) $aiUsageSnapshot->codex_tokens : 0;
    $aiUsageUpdatedAt = $hasAiUsageSnapshot && $aiUsageSnapshot->captured_at
        ? $aiUsageSnapshot->captured_at->timezone(config('app.timezone'))->format($currentLocale === 'en' ? 'M j, Y H:i' : 'd.m.Y H:i')
        : null;
    $aiUsageUpdatedAtIso = $hasAiUsageSnapshot && $aiUsageSnapshot->captured_at
        ? $aiUsageSnapshot->captured_at->timezone(config('app.timezone'))->toIso8601String()
        : null;

    $structuredData = [
        '@context' => 'https://schema.org',
        '@type' => 'Person',
        'name' => $currentLocale === 'en' ? 'Yevgeniy Ampleev' : 'Евгений Амплеев',
        'jobTitle' => $currentLocale === 'en' ? 'IT Delivery Manager' : 'IT Delivery Manager, руководитель поставки IT-продуктов',
        'url' => route($resumeRoute),
        'image' => $portraitUrl,
    ];
@endphp

@extends('layouts.app')

@section('title', $copy['meta']['title'])
@section('document_title', $copy['meta']['title'])
@section('description', $copy['meta']['description'])
@section('meta_description', $copy['meta']['description'])
@section('og_title', $copy['meta']['title'])
@section('og_description', $copy['meta']['description'])
@section('main_image_path', $portraitUrl)
@section('page_url', route($resumeRoute))
@section('canonical_url', route($resumeRoute))
@section('alternate_url_ru', $resumeRuUrl)
@section('alternate_url_en', $resumeEnUrl)
@section('x_default_url', $resumeEnUrl)
@section('minimal_frontend', '1')

@section('custom_css')
    @parent
    <link rel="preload"
          as="image"
          type="image/avif"
          href="{{ asset('assets/img/about-me/about-me-hero-960.avif') }}"
          imagesrcset="{{ asset('assets/img/about-me/about-me-hero-640.avif') }} 640w, {{ asset('assets/img/about-me/about-me-hero-960.avif') }} 960w, {{ asset('assets/img/about-me/about-me-hero-1280.avif') }} 1280w"
          imagesizes="(max-width: 767px) 100vw, 38vw"
          fetchpriority="high">
    <link href="{{ asset('assets/css/about-me.bundle.min.css') }}?v={{ filemtime(public_path('assets/css/about-me.bundle.min.css')) }}" rel="stylesheet" type="text/css" media="all">
@endsection

@section('structured_data')
    <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endsection

@section('content')
    @include('layouts.navbar_white')

    <main class="about-profile"
          data-about-profile
          data-about-analytics-enabled="{{ app()->environment('production') ? 'true' : 'false' }}"
          data-about-analytics-url="{{ route('site_page_visits.store', [], false) }}">
        <section class="about-profile__hero" aria-labelledby="about-profile-title">
            <div class="container">
                <div class="about-profile__hero-grid">
                    <div class="about-profile__hero-copy">
                        <p class="about-profile__eyebrow">{{ $copy['hero']['eyebrow'] }}</p>
                        <h1 id="about-profile-title">{{ $copy['hero']['heading'] }}</h1>

                        <div class="about-profile__hero-text">
                            @foreach($copy['hero']['paragraphs'] as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </div>

                        <div class="about-profile__actions">
                            <a href="{{ $resumeUrl }}"
                               class="about-profile__button about-profile__button--primary"
                               target="_blank"
                               rel="noopener"
                               data-about-event="about_resume_open"
                               data-placement="hero">
                                {{ $copy['hero']['resume'] }}
                                <span aria-hidden="true">↗</span>
                            </a>
                            <a href="https://t.me/mpleeve"
                               class="about-profile__button about-profile__button--secondary"
                               target="_blank"
                               rel="noopener noreferrer"
                               data-about-event="about_telegram_click"
                               data-placement="hero">
                                {{ $copy['hero']['telegram'] }}
                            </a>
                        </div>
                    </div>

                    <figure class="about-profile__portrait">
                        <picture>
                            <source type="image/avif"
                                    srcset="{{ asset('assets/img/about-me/about-me-hero-640.avif') }} 640w, {{ asset('assets/img/about-me/about-me-hero-960.avif') }} 960w, {{ asset('assets/img/about-me/about-me-hero-1280.avif') }} 1280w"
                                    sizes="(max-width: 767px) 100vw, 38vw">
                            <source type="image/webp"
                                    srcset="{{ asset('assets/img/about-me/about-me-hero-640.webp') }} 640w, {{ asset('assets/img/about-me/about-me-hero-960.webp') }} 960w, {{ asset('assets/img/about-me/about-me-hero-1280.webp') }} 1280w"
                                    sizes="(max-width: 767px) 100vw, 38vw">
                            <img src="{{ asset('assets/img/about-me/about-me-hero-960.jpg') }}"
                                 srcset="{{ asset('assets/img/about-me/about-me-hero-640.jpg') }} 640w, {{ asset('assets/img/about-me/about-me-hero-960.jpg') }} 960w, {{ asset('assets/img/about-me/about-me-hero-1280.jpg') }} 1280w"
                                 sizes="(max-width: 767px) 100vw, 38vw"
                                 width="1280"
                                 height="1254"
                                 alt="{{ $copy['hero']['photo_alt'] }}"
                                 fetchpriority="high"
                                 decoding="async">
                        </picture>
                        <figcaption aria-hidden="true">
                            <span>Delivery</span>
                            <span>Engineering</span>
                            <span>Production</span>
                        </figcaption>
                    </figure>
                </div>
            </div>
        </section>

        <section class="about-profile__section about-profile__proof" aria-labelledby="about-proof-title">
            <div class="container">
                <div class="about-profile__section-head">
                    <p class="about-profile__eyebrow">{{ $copy['proof']['eyebrow'] }}</p>
                    <h2 id="about-proof-title">{{ $copy['proof']['heading'] }}</h2>
                </div>

                <p class="about-profile__companies">{{ $copy['proof']['companies'] }}</p>

                <div class="about-profile__metrics">
                    @foreach($copy['proof']['metrics'] as $metric)
                        <article class="about-profile__metric">
                            <strong>{{ $metric['value'] }}</strong>
                            <h3>{{ $metric['label'] }}</h3>
                            <p>{{ $metric['description'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="about-profile__section about-profile__ownership" aria-labelledby="about-ownership-title">
            <div class="container">
                <div class="about-profile__section-head about-profile__section-head--split">
                    <p class="about-profile__eyebrow">{{ $copy['ownership']['eyebrow'] }}</p>
                    <h2 id="about-ownership-title">{{ $copy['ownership']['heading'] }}</h2>
                </div>

                <div class="about-profile__ownership-grid">
                    @foreach($copy['ownership']['items'] as $item)
                        <article class="about-profile__ownership-card">
                            <span aria-hidden="true">{{ $item['number'] }}</span>
                            <h3>{{ $item['title'] }}</h3>
                            <p>{{ $item['text'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="about-profile__section about-profile__experience" aria-labelledby="about-experience-title">
            <div class="container">
                <div class="about-profile__section-head about-profile__section-head--split">
                    <p class="about-profile__eyebrow">{{ $copy['experience']['eyebrow'] }}</p>
                    <h2 id="about-experience-title">{{ $copy['experience']['heading'] }}</h2>
                </div>

                <ol class="about-profile__timeline">
                    @foreach($copy['experience']['items'] as $item)
                        <li>
                            <time>{{ $item['date'] }}</time>
                            <div>
                                <h3>{{ $item['company'] }}</h3>
                                <p>{{ $item['text'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ol>

                <a href="{{ $resumeUrl }}"
                   class="about-profile__text-link"
                   target="_blank"
                   rel="noopener"
                   data-about-event="about_resume_open"
                   data-placement="experience">
                    {{ $copy['experience']['resume_link'] }} <span aria-hidden="true">↗</span>
                </a>
            </div>
        </section>

        <section class="about-profile__section about-profile__products" aria-labelledby="about-products-title" data-about-products>
            <div class="container">
                <div class="about-profile__section-head about-profile__section-head--with-intro">
                    <div>
                        <p class="about-profile__eyebrow">{{ $copy['products']['eyebrow'] }}</p>
                        <h2 id="about-products-title">{{ $copy['products']['heading'] }}</h2>
                    </div>
                    <p>{{ $copy['products']['intro'] }}</p>
                </div>

                <div class="about-profile__product-grid">
                    @foreach($copy['products']['items'] as $product)
                        <article class="about-profile__product-card about-profile__product-card--{{ $product['key'] }}">
                            <p class="about-profile__product-status">{{ $product['status'] }}</p>
                            <h3 @if($product['key'] === 'aiya') translate="no" @endif>{{ $product['name'] }}</h3>
                            <p>{{ $product['text'] }}</p>
                            <a href="{{ $product['url'] }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               data-about-event="about_project_click"
                               data-project="{{ $product['key'] }}">
                                {{ $copy['products']['link_label'] }} <span aria-hidden="true">↗</span>
                            </a>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="about-profile__section about-profile__ai" aria-labelledby="about-ai-title">
            <div class="container">
                <div class="about-profile__ai-grid">
                    <div class="about-profile__ai-copy">
                        <p class="about-profile__eyebrow">{{ $copy['ai']['eyebrow'] }}</p>
                        <h2 id="about-ai-title">{{ $copy['ai']['heading'] }}</h2>
                        @foreach($copy['ai']['paragraphs'] as $paragraph)
                            <p>{{ $paragraph }}</p>
                        @endforeach
                    </div>

                    <div class="about-profile__counter"
                         aria-live="off"
                         data-ai-usage-block
                         data-ai-usage-latest-url="{{ route('api.ai_usage.latest') }}"
                         data-ai-usage-poll-interval="60000"
                         data-ai-usage-locale="{{ $localeTag }}"
                         data-ai-usage-timezone="{{ config('app.timezone') }}"
                         data-ai-usage-updated-label="{{ $copy['ai']['updated'] }}">
                        <div class="about-profile__counter-head">
                            <span>{{ $copy['ai']['auto'] }}</span>
                            <time data-ai-usage-updated
                                  @if($aiUsageUpdatedAtIso) datetime="{{ $aiUsageUpdatedAtIso }}" data-ai-usage-updated-current="{{ $aiUsageUpdatedAtIso }}" @endif
                                  @if(!$aiUsageUpdatedAt) hidden @endif>{{ $copy['ai']['updated'] }}: {{ $aiUsageUpdatedAt }}</time>
                        </div>

                        <div class="about-profile__counter-total">
                            <span>{{ $copy['ai']['total'] }}</span>
                            <strong data-ai-token-field="total_tokens"
                                    @if($hasAiUsageSnapshot) data-ai-token-count="{{ $aiTotalTokens }}" @endif>{{ $hasAiUsageSnapshot ? $formatTokens($aiTotalTokens) : $copy['ai']['fallback'] }}</strong>
                        </div>

                        <div class="about-profile__counter-tools">
                            <div>
                                <span>{{ $copy['ai']['codex'] }}</span>
                                <strong data-ai-token-field="codex_tokens"
                                        @if($hasAiUsageSnapshot) data-ai-token-count="{{ $aiCodexTokens }}" @endif>{{ $hasAiUsageSnapshot ? $formatTokens($aiCodexTokens) : '—' }}</strong>
                            </div>
                            <div>
                                <span>{{ $copy['ai']['claude'] }}</span>
                                <strong data-ai-token-field="claude_tokens"
                                        @if($hasAiUsageSnapshot) data-ai-token-count="{{ $aiClaudeTokens }}" @endif>{{ $hasAiUsageSnapshot ? $formatTokens($aiClaudeTokens) : '—' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="about-profile__section about-profile__cta" aria-labelledby="about-cta-title">
            <div class="container">
                <div class="about-profile__cta-panel">
                    <p class="about-profile__eyebrow">{{ $copy['cta']['eyebrow'] }}</p>
                    <h2 id="about-cta-title">{{ $copy['cta']['heading'] }}</h2>
                    <p>{{ $copy['cta']['text'] }}</p>

                    <div class="about-profile__actions about-profile__actions--centered">
                        <a href="{{ $resumeUrl }}"
                           class="about-profile__button about-profile__button--primary"
                           target="_blank"
                           rel="noopener"
                           data-about-event="about_resume_open"
                           data-placement="final">
                            {{ $copy['cta']['resume'] }} <span aria-hidden="true">↗</span>
                        </a>
                        <a href="https://t.me/mpleeve"
                           class="about-profile__button about-profile__button--secondary"
                           target="_blank"
                           rel="noopener noreferrer"
                           data-about-event="about_telegram_click"
                           data-placement="final">{{ $copy['cta']['telegram'] }}</a>
                        <a href="mailto:e@ampleev.com"
                           class="about-profile__button about-profile__button--secondary"
                           data-about-event="about_email_click"
                           data-placement="final">{{ $copy['cta']['email'] }}</a>
                    </div>

                    <a href="{{ $resumeDownloadUrl }}"
                       class="about-profile__download"
                       data-about-event="about_resume_download"
                       data-about-first-party="false">{{ $copy['cta']['download'] }} ↓</a>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('pageScript')
    @parent
    <script src="{{ asset('assets/js/about-me.js') }}?v={{ filemtime(public_path('assets/js/about-me.js')) }}" defer></script>
@endsection
