@php
    use App\Support\SiteLocale;

    $currentLocale = SiteLocale::resolve(request());
    $aboutMeRoute = SiteLocale::routeNameForLocale('static_pages.about_me', $currentLocale);
    $aboutMeRuUrl = route('static_pages.about_me');
    $aboutMeEnUrl = route('en.static_pages.about_me');
    $locale_switch_urls = [
        'ru' => $aboutMeRuUrl,
        'en' => $aboutMeEnUrl,
    ];
    $copy = $currentLocale === 'en'
        ? [
            'title' => 'About Me',
            'description' => 'On this page you can find concise information about my background, expertise, and focus areas.',
            'badge' => 'Summary',
            'heading' => 'About Me',
            'lead_1' => '<b>IT</b> manager with experience in <b>FinTech</b>, large digital businesses, and startups. I work with a strong focus on business metrics such as <b>Retention</b>, <b>LTV</b>, <b>P&L</b>, and <b>TTM</b>. I have experience leading teams, launching and scaling IT products (<b>CRM</b>, <b>mobile apps</b>), and improving delivery processes through <b>Agile</b> transformations and internal methodologies.',
            'lead_2' => 'I keep my technical expertise current in <b>Go</b>, <b>Swift</b>, <b>JS</b>, and <b>CI/CD</b>, and actively apply <b>AI/ML</b> technologies in practice.',
            'numbers_heading' => 'At a glance',
            'career_heading' => 'Career timeline',
            'stats' => [
                ['value' => '19', 'suffix' => ' years', 'label' => 'Total experience in IT'],
                ['value' => '70', 'suffix' => '', 'label' => 'Teams I have worked with'],
                ['value' => '105', 'suffix' => '', 'label' => 'Scrum Masters trained'],
                ['value' => '9', 'suffix' => ' out of 10', 'label' => 'Average facilitation feedback'],
                ['value' => '4', 'suffix' => '', 'label' => 'Delivery methodologies developed'],
                ['value' => '461', 'suffix' => '', 'label' => 'People working with those methodologies'],
            ],
            'career' => [
                ['date' => 'November 2024', 'company' => 'Sheremetyevo', 'company_url' => 'https://www.svo.aero/en/main', 'role' => 'Head of Development Transformation'],
                ['date' => 'February 2024', 'company' => 'Gazprombank', 'company_url' => 'https://www.gazprombank.ru', 'role' => 'Agile Transformation Lead'],
                ['date' => 'February 2021', 'company' => 'VTB', 'company_url' => 'https://www.vtb.ru/', 'role' => 'Agile Coach'],
                ['date' => 'February 2019', 'company' => 'Ingosstrakh', 'company_url' => 'https://www.ingos.ru', 'role' => 'Scrum Master'],
                ['date' => 'November 2015', 'company' => 'Alfa Bank', 'company_url' => 'https://alfabank.ru', 'role' => 'Website Manager'],
                ['date' => 'October 2010', 'company' => 'Public Opinion Foundation', 'company_url' => 'https://fom.ru', 'role' => 'Senior Project Manager'],
                ['date' => 'June 2010', 'company' => 'Faculty of Computer Engineering, PSU', 'company_url' => 'https://fvt.pnzgu.ru', 'role' => 'Software Engineer'],
                ['date' => 'May 2007', 'company' => 'Ampleev.com', 'company_url' => 'https://ampleev.com/', 'role' => 'Independent entrepreneur (web, mobile)'],
            ],
            'company_logos' => [
                ['company' => 'Gazprombank', 'company_url' => 'https://www.gazprombank.ru', 'logo' => 'assets/img/career-logos/logo_gazprombank_Abali.ru.svg', 'class' => 'gazprombank'],
                ['company' => 'VTB', 'company_url' => 'https://www.vtb.ru/', 'logo' => 'assets/img/career-logos/logo-new-engVTB.svg', 'class' => 'vtb'],
                ['company' => 'Ingosstrakh', 'company_url' => 'https://www.ingos.ru', 'logo' => 'assets/img/career-logos/ingosstrakh-logo.svg', 'class' => 'ingosstrakh'],
                ['company' => 'Alfa Bank', 'company_url' => 'https://alfabank.ru', 'logo' => 'assets/img/career-logos/alfa_logo.svg', 'class' => 'alfa'],
            ],
            'ai_usage' => [
                'eyebrow' => 'AI usage',
                'heading' => 'Tokens I have used:',
                'description' => 'Aggregated usage across working AI tools. Only totals are published; prompts and conversation contents stay private.',
                'total_label' => 'Tokens I have used',
                'claude_label' => 'Claude',
                'codex_label' => 'Codex',
                'updated_label' => 'Updated',
                'fallback' => 'Data is updating',
            ],
        ]
        : [
            'title' => 'Обо мне',
            'description' => 'На данной странице вы получите исчерпывающую информацию обо мне',
            'badge' => 'Коротко',
            'heading' => 'Обо мне',
            'lead_1' => '<b>IT</b>-менеджер с опытом в <b>FinTech</b>, крупном цифровом бизнесе и стартапах. Работаю с фокусом на ключевые бизнес-метрики: <b>Retention</b>, <b>LTV</b>, <b>P&L</b>, <b>TTM</b>. Имею опыт в управлении командами, запуске и развитии it-продуктов (<b>CRM</b>, <b>мобильные приложения</b>), системной работе над процессами (<b>Agile</b>-трансформации, разработка методологий).',
            'lead_2' => 'Сохраняю актуальную техническую экспертизу (<b>Go</b>, <b>Swift</b>, <b>JS</b>, <b>CI/CD</b>) и применяю <b>AI/ML</b>-технологии.',
            'numbers_heading' => 'В цифрах',
            'career_heading' => 'Карьера',
            'stats' => [
                ['value' => '19', 'suffix' => ' лет', 'label' => 'Общий опыт в IT'],
                ['value' => '70', 'suffix' => '', 'label' => 'Количество команд, с которыми работал'],
                ['value' => '105', 'suffix' => '', 'label' => 'Количество обученных Scrum Masters'],
                ['value' => '9', 'suffix' => ' из 10', 'label' => 'Средняя обратная связь по фасилитации'],
                ['value' => '4', 'suffix' => '', 'label' => 'Количество разработанных методик'],
                ['value' => '461', 'suffix' => '', 'label' => 'Количество людей, работающих по разработанным методикам'],
            ],
            'career' => [
                ['date' => 'Ноябрь 2024', 'company' => 'Шереметьево', 'company_url' => 'https://www.svo.aero/en/main', 'role' => 'Руководитель трансформации разработки'],
                ['date' => 'Февраль 2024', 'company' => 'Газпромбанк', 'company_url' => 'https://www.gazprombank.ru', 'role' => 'Agile transformation lead'],
                ['date' => 'Февраль 2021', 'company' => 'ВТБ', 'company_url' => 'https://www.vtb.ru/', 'role' => 'Agile Coach'],
                ['date' => 'Февраль 2019', 'company' => 'Ингосстрах', 'company_url' => 'https://www.ingos.ru', 'role' => 'Scrum Master'],
                ['date' => 'Ноябрь 2015', 'company' => 'Альфа Банк', 'company_url' => 'https://alfabank.ru', 'role' => 'Web Site менеджер'],
                ['date' => 'Октябрь 2010', 'company' => 'Фонд Общественное Мнение', 'company_url' => 'https://fom.ru', 'role' => 'Старший менеджер проектов'],
                ['date' => 'Июнь 2010', 'company' => 'ФВТ ПГУ', 'company_url' => 'https://fvt.pnzgu.ru', 'role' => 'Инженер-программист'],
                ['date' => 'Май 2007', 'company' => 'Ampleev.com', 'company_url' => 'https://ampleev.com/', 'role' => 'Индивидуальный предприниматель (web, mobile)'],
            ],
            'company_logos' => [
                ['company' => 'Газпромбанк', 'company_url' => 'https://www.gazprombank.ru', 'logo' => 'assets/img/career-logos/logo_gazprombank_Abali.ru.svg', 'class' => 'gazprombank'],
                ['company' => 'ВТБ', 'company_url' => 'https://www.vtb.ru/', 'logo' => 'assets/img/career-logos/logo-new-engVTB.svg', 'class' => 'vtb'],
                ['company' => 'Ингосстрах', 'company_url' => 'https://www.ingos.ru', 'logo' => 'assets/img/career-logos/ingosstrakh-logo.svg', 'class' => 'ingosstrakh'],
                ['company' => 'Альфа Банк', 'company_url' => 'https://alfabank.ru', 'logo' => 'assets/img/career-logos/alfa_logo.svg', 'class' => 'alfa'],
            ],
            'ai_usage' => [
                'eyebrow' => 'AI usage',
                'heading' => 'Я использовал токенов:',
                'description' => 'Суммарное использование рабочих AI-инструментов. Публично показываются только агрегированные цифры; промпты и содержимое диалогов не синхронизируются.',
                'total_label' => 'Я использовал токенов',
                'claude_label' => 'Claude',
                'codex_label' => 'Codex',
                'updated_label' => 'Обновлено',
                'fallback' => 'Данные обновляются',
            ],
        ];

    $hasAiUsageSnapshot = isset($aiUsageSnapshot) && $aiUsageSnapshot;
    $aiTotalTokens = $hasAiUsageSnapshot ? (int) $aiUsageSnapshot->total_tokens : 0;
    $aiClaudeTokens = $hasAiUsageSnapshot ? (int) $aiUsageSnapshot->claude_tokens : 0;
    $aiCodexTokens = $hasAiUsageSnapshot ? (int) $aiUsageSnapshot->codex_tokens : 0;
    $formatTokens = static function (int $value): string {
        return number_format($value, 0, ',', ' ');
    };
    $aiTotalFormatted = $hasAiUsageSnapshot ? $formatTokens($aiTotalTokens) : $copy['ai_usage']['fallback'];
    $aiClaudeFormatted = $hasAiUsageSnapshot ? $formatTokens($aiClaudeTokens) : '—';
    $aiCodexFormatted = $hasAiUsageSnapshot ? $formatTokens($aiCodexTokens) : '—';
    $aiClaudeShare = $aiTotalTokens > 0 ? round($aiClaudeTokens / $aiTotalTokens * 100, 2) : 0;
    $aiCodexShare = max(0, 100 - $aiClaudeShare);
    $aiUsageUpdatedAt = $hasAiUsageSnapshot && $aiUsageSnapshot->captured_at
        ? $aiUsageSnapshot->captured_at->timezone(config('app.timezone'))->format($currentLocale === 'en' ? 'M j, Y H:i' : 'd.m.Y H:i')
        : null;
@endphp

@extends('layouts.app')

@section('title', $copy['title'])
@section('description', $copy['description'])
@section('page_url', route($aboutMeRoute))
@section('canonical_url', route($aboutMeRoute))
@section('alternate_url_ru', $aboutMeRuUrl)
@section('alternate_url_en', $aboutMeEnUrl)
@section('x_default_url', $aboutMeEnUrl)

@section('custom_css')
    @parent
@endsection

@section('sidebar')
    @parent
    <link href="{{ asset('assets/css/custom.css') }}?v={{ filemtime(public_path('assets/css/custom.css')) }}" rel="stylesheet"
          type="text/css" media="all"/>
@endsection

@section('content')
    @include('layouts.navbar_white')

    <section class="about-ai-usage-section">
        <div class="container">
            <div class="about-ai-usage"
                 data-ai-usage-block
                 data-ai-usage-latest-url="{{ route('api.ai_usage.latest') }}"
                 data-ai-usage-poll-interval="10000"
                 data-ai-usage-locale="{{ $currentLocale === 'en' ? 'en-US' : 'ru-RU' }}"
                 data-ai-usage-updated-label="{{ $copy['ai_usage']['updated_label'] }}">
                <div class="about-ai-usage__intro">
                    <span class="about-ai-usage__eyebrow">{{ $copy['ai_usage']['eyebrow'] }}</span>
                    <h2>{{ $copy['ai_usage']['heading'] }}</h2>
                    <p>{{ $copy['ai_usage']['description'] }}</p>
                    <span class="about-ai-usage__updated"
                          data-ai-usage-updated
                          @if(!$aiUsageUpdatedAt) hidden @endif>{{ $copy['ai_usage']['updated_label'] }}: {{ $aiUsageUpdatedAt }}</span>
                </div>

                <div class="about-ai-usage__metric" aria-label="{{ $copy['ai_usage']['total_label'] }}">
                    <span class="about-ai-usage__number {{ $hasAiUsageSnapshot ? '' : 'about-ai-usage__number--fallback' }}"
                          data-ai-token-field="total_tokens"
                          @if($hasAiUsageSnapshot) data-ai-token-count="{{ $aiTotalTokens }}" @endif>{{ $aiTotalFormatted }}</span>
                </div>

                <div class="about-ai-usage__details" aria-label="{{ $currentLocale === 'en' ? 'Token usage by tool' : 'Использование токенов по инструментам' }}">
                    <div class="about-ai-usage__cards">
                        <div class="about-ai-usage__tool-card">
                            <span>{{ $copy['ai_usage']['claude_label'] }}</span>
                            <strong data-ai-token-field="claude_tokens" @if($hasAiUsageSnapshot) data-ai-token-count="{{ $aiClaudeTokens }}" @endif>{{ $aiClaudeFormatted }}</strong>
                        </div>
                        <div class="about-ai-usage__tool-card">
                            <span>{{ $copy['ai_usage']['codex_label'] }}</span>
                            <strong data-ai-token-field="codex_tokens" @if($hasAiUsageSnapshot) data-ai-token-count="{{ $aiCodexTokens }}" @endif>{{ $aiCodexFormatted }}</strong>
                        </div>
                    </div>

                    @if($hasAiUsageSnapshot)
                        <div class="about-ai-usage__ratio" aria-hidden="true">
                            <span class="about-ai-usage__ratio-claude" style="width: {{ $aiClaudeShare }}%"></span>
                            <span class="about-ai-usage__ratio-codex" style="width: {{ $aiCodexShare }}%"></span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="about-intro-section">
        <div class="container aos-init aos-animate" data-aos="fade-up">
            <div class="row align-items-center justify-content-around">
                <div class="col-md-5 col-xl-6 mb-4 mb-md-0">
                    <img src="{{ asset('assets/img/about_me_11_03.PNG') }}" alt="Image" class="rounded shadow-3d">
                </div>
                {{--                init commit --}}
                <div class="col-md-7 col-xl-6">
                    <div class="row justify-content-center">
                        <div class="col-xl-8 col-lg-10 article-typography">
                            <span class="badge badge-primary">{{ $copy['badge'] }}</span>
                            <div class="my-3">
                                <h1>{{ $copy['heading'] }}</h1>
                            </div>
                            <p class="lead">{!! $copy['lead_1'] !!}</p>
                            <br/>

                            <p class="lead">{!! $copy['lead_2'] !!}</p>
                            <br/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-0">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-12">
                    <div class="career-logo-strip career-logo-strip--stats">
                        @foreach($copy['company_logos'] as $companyLogo)
                            <a href="{{ $companyLogo['company_url'] }}"
                               class="career-logo-link {{ isset($companyLogo['class']) ? 'career-logo-link--' . $companyLogo['class'] : '' }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               aria-label="{{ $companyLogo['company'] }}">
                                <img src="{{ asset($companyLogo['logo']) }}?v={{ filemtime(public_path($companyLogo['logo'])) }}" alt="{{ $companyLogo['company'] }}">
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('pageScript')
    @parent
    <script>
        (function () {
            var block = document.querySelector('[data-ai-usage-block]');
            if (!block) return;

            var counters = document.querySelectorAll('[data-ai-token-field]');
            if (!counters.length) return;

            var locale = block.getAttribute('data-ai-usage-locale') || 'ru-RU';
            var latestUrl = block.getAttribute('data-ai-usage-latest-url');
            var pollInterval = Math.max(5000, parseInt(block.getAttribute('data-ai-usage-poll-interval'), 10) || 10000);
            var updatedLabel = block.getAttribute('data-ai-usage-updated-label') || 'Обновлено';
            var formatter = new Intl.NumberFormat(locale);
            var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            var initialAnimated = false;
            var isFetching = false;

            var readCurrentValue = function (element) {
                var attrValue = parseInt(element.getAttribute('data-ai-token-count'), 10);
                if (Number.isFinite(attrValue)) return attrValue;

                var textValue = parseInt((element.textContent || '').replace(/\D/g, ''), 10);
                return Number.isFinite(textValue) ? textValue : 0;
            };

            var renderCounter = function (element, value) {
                element.textContent = formatter.format(value);
                element.setAttribute('data-ai-token-count', String(value));
                element.classList.remove('about-ai-usage__number--fallback');
            };

            var animateCounter = function (element, from, target, duration) {
                if (reduceMotion) {
                    renderCounter(element, target);
                    return;
                }

                var start = null;
                var ease = function (t) {
                    return t < 0.5
                        ? 4 * t * t * t
                        : 1 - Math.pow(-2 * t + 2, 3) / 2;
                };

                var step = function (timestamp) {
                    if (!start) start = timestamp;
                    var progress = Math.min((timestamp - start) / duration, 1);
                    var value = Math.round(from + ((target - from) * ease(progress)));
                    element.textContent = formatter.format(value);

                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                        return;
                    }

                    renderCounter(element, target);
                };

                window.requestAnimationFrame(step);
            };

            var updateCounter = function (field, value, animate) {
                var element = document.querySelector('[data-ai-token-field="' + field + '"]');
                var target = parseInt(value, 10);
                if (!element || !Number.isFinite(target)) return;

                var previous = readCurrentValue(element);
                if (previous === target && element.hasAttribute('data-ai-token-count')) return;

                if (animate) {
                    animateCounter(element, previous, target, 2400);
                    return;
                }

                renderCounter(element, target);
            };

            var formatUpdatedAt = function (value) {
                if (!value) return '';

                var date = new Date(value);
                if (Number.isNaN(date.getTime())) return '';

                var options = locale === 'en-US'
                    ? { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' }
                    : { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' };

                return new Intl.DateTimeFormat(locale, options).format(date).replace(',', '');
            };

            var updateTimestamp = function (capturedAt) {
                var element = document.querySelector('[data-ai-usage-updated]');
                var formatted = formatUpdatedAt(capturedAt);
                if (!element || !formatted) return;

                element.textContent = updatedLabel + ': ' + formatted;
                element.hidden = false;
            };

            var refreshSnapshot = function () {
                if (!latestUrl || isFetching || document.hidden) return;

                isFetching = true;

                fetch(latestUrl, {
                    headers: { 'Accept': 'application/json' },
                    cache: 'no-store',
                    credentials: 'same-origin'
                })
                    .then(function (response) {
                        if (!response.ok) throw new Error('AI usage snapshot request failed');
                        return response.json();
                    })
                    .then(function (data) {
                        var snapshot = data && data.snapshot;
                        if (!snapshot) return;

                        updateCounter('total_tokens', snapshot.total_tokens, true);
                        updateCounter('claude_tokens', snapshot.claude_tokens, true);
                        updateCounter('codex_tokens', snapshot.codex_tokens, true);
                        updateTimestamp(snapshot.captured_at);
                    })
                    .catch(function () {})
                    .finally(function () {
                        isFetching = false;
                    });
            };

            var animateInitialCounters = function () {
                if (initialAnimated) return;
                initialAnimated = true;

                counters.forEach(function (counter) {
                    var target = parseInt(counter.getAttribute('data-ai-token-count'), 10);
                    if (Number.isFinite(target)) {
                        animateCounter(counter, 0, target, 3200);
                    }
                });
            };

            if ('IntersectionObserver' in window) {
                var observer = new IntersectionObserver(function (entries, instance) {
                    entries.forEach(function (entry) {
                        if (!entry.isIntersecting) return;
                        animateInitialCounters();
                        instance.disconnect();
                    });
                }, { threshold: 0.35 });

                observer.observe(block);
            } else {
                animateInitialCounters();
            }

            if (latestUrl) {
                window.setTimeout(refreshSnapshot, 1500);
                window.setInterval(refreshSnapshot, pollInterval);

                document.addEventListener('visibilitychange', function () {
                    if (!document.hidden) refreshSnapshot();
                });
            }
        })();
    </script>
@endsection
