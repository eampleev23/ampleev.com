<!doctype html>
<html lang="{{ $site_locale ?? 'ru' }}">

<head>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#0071ff">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->

    @php
        // Отключение внешней аналитики для текущего браузера (чтобы исключить собственные визиты из статистики):
        // - Добавь ?metrika=off к любому URL → внешняя аналитика отключится (и поставится cookie metrika_disabled=1)
        // - Добавь ?metrika=on → внешняя аналитика включится обратно (cookie будет очищен)
        $metrikaQuery = request()->query('metrika');
        $metrikaDisabled = $metrikaQuery === 'off' || ($metrikaQuery !== 'on' && request()->cookie('metrika_disabled') === '1');
        $ownerDeviceDetected = is_string(request()->cookie('owner_device_key')) && request()->cookie('owner_device_key') !== '';
        $analyticsDisabledForAdmin = auth()->check() && auth()->user()->is_admin;
        $analyticsDisabledForPath = request()->is(
            'admin*',
            'drafts*',
            'login',
            'profile',
            'confirm_subscriber*',
            'confirm-subscriber*',
            'en/drafts*',
            'en/login',
            'en/profile',
            'en/confirm_subscriber*',
            'en/confirm-subscriber*'
        );
        $externalAnalyticsDisabled = $metrikaDisabled || $ownerDeviceDetected || $analyticsDisabledForAdmin || $analyticsDisabledForPath;
        $firstPartyAnalyticsDisabled = $analyticsDisabledForAdmin || $analyticsDisabledForPath;
        $metrikaId = 57345031;
        $googleAnalyticsMeasurementId = config('services.google_analytics.measurement_id');
    @endphp

    @if(app()->environment('production'))
        <script type="text/javascript">
            (function () {
                try {
                    var q = new URLSearchParams(window.location.search);
                    var m = q.get('metrika');
                    if (m === 'off') {
                        document.cookie = 'metrika_disabled=1; path=/; max-age=31536000; samesite=lax';
                    }
                    if (m === 'on') {
                        document.cookie = 'metrika_disabled=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT; samesite=lax';
                    }
                } catch (e) {}
            })();
        </script>
    @endif

    @if(app()->environment('production') && !$externalAnalyticsDisabled && $googleAnalyticsMeasurementId)
        <!-- Google Analytics 4 -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleAnalyticsMeasurementId }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());
            gtag('config', @json($googleAnalyticsMeasurementId));
        </script>
        <!-- /Google Analytics 4 -->
    @endif

    @if(app()->environment('production') && !$externalAnalyticsDisabled)
        <!-- Yandex.Metrika counter -->
        <script type="text/javascript">
            window.METRIKA_COUNTER_ID = {{$metrikaId}};

            (function (m, e, t, r, i, k, a) {
                m[i] = m[i] || function () {
                    (m[i].a = m[i].a || []).push(arguments)
                };
                m[i].l = 1 * new Date();
                k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
            })
            (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

            ym({{$metrikaId}}, "init", {
                clickmap: true,
                trackLinks: true,
                accurateTrackBounce: true,
                webvisor: true
            });
        </script>
        <noscript>
            <div><img src="https://mc.yandex.ru/watch/{{$metrikaId}}" style="position:absolute; left:-9999px;" alt=""/></div>
        </noscript>
        <!-- /Yandex.Metrika counter -->
    @endif

    <meta charset="utf-8">

    @php
        $resolvedPageUrl = trim($__env->yieldContent('page_url')) ?: url()->current();
        $resolvedCanonicalUrl = trim($__env->yieldContent('canonical_url')) ?: $resolvedPageUrl;
        $resolvedAlternateRuUrl = trim($__env->yieldContent('alternate_url_ru'));
        $resolvedAlternateEnUrl = trim($__env->yieldContent('alternate_url_en'));
        $resolvedXDefaultUrl = trim($__env->yieldContent('x_default_url')) ?: ($resolvedAlternateEnUrl ?: $resolvedAlternateRuUrl ?: $resolvedCanonicalUrl);
        $resolvedMetaRobots = trim($__env->yieldContent('meta_robots'));
        $resolvedMainImagePath = trim($__env->yieldContent('main_image_path'));
        $resolvedTitle = trim($__env->yieldContent('title'));
        $resolvedDescription = trim($__env->yieldContent('description'));
        $resolvedSiteTitleSuffix = $locale_labels['site_title_suffix'] ?? 'Амплеев Евгений';
        $resolvedOgLocale = ($site_locale ?? 'ru') === 'en' ? 'en_US' : 'ru_RU';
    @endphp

    <title>{{ $resolvedTitle }} | {{ $resolvedSiteTitleSuffix }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $resolvedDescription }} {{ ($site_locale ?? 'ru') === 'en' ? 'Personal blog.' : 'Персональный блог.' }}">
    @if($resolvedMetaRobots !== '')
    <meta name="robots" content="{{ $resolvedMetaRobots }}">
    @endif

    <link rel="canonical" href="{{ $resolvedCanonicalUrl }}">
    @if($resolvedAlternateRuUrl !== '')
    <link rel="alternate" hreflang="ru" href="{{ $resolvedAlternateRuUrl }}">
    @endif
    @if($resolvedAlternateEnUrl !== '')
    <link rel="alternate" hreflang="en" href="{{ $resolvedAlternateEnUrl }}">
    @endif
    <link rel="alternate" hreflang="x-default" href="{{ $resolvedXDefaultUrl }}">

    <meta property="og:url"
          content="{{ $resolvedCanonicalUrl }}"/>
    <meta property="og:type" content="@yield('og_type', 'website')"/>
    <meta property="og:site_name" content="Ampleev.com"/>
    <meta property="og:locale" content="{{ $resolvedOgLocale }}"/>
    <meta property="og:title" content="{{ $resolvedTitle }} | {{ $resolvedSiteTitleSuffix }}"/>
    <meta property="og:description" content="{{ $resolvedDescription }}"/>
    <meta property="og:image" content="{{ $resolvedMainImagePath }}"/>
    <meta property="og:image:secure_url" content="{{ $resolvedMainImagePath }}"/>
    <meta property="og:image:alt" content="{{ $resolvedTitle }}"/>
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:title" content="{{ $resolvedTitle }} | {{ $resolvedSiteTitleSuffix }}"/>
    <meta name="twitter:description" content="{{ $resolvedDescription }}"/>
    <meta name="twitter:image" content="{{ $resolvedMainImagePath }}"/>
    <meta name="twitter:image:alt" content="{{ $resolvedTitle }}"/>

    {{-- Debug: позволяет быстро проверить, какой country_code видит Laravel за Cloudflare --}}
    @if(app()->environment('production') && request()->boolean('debug_country'))
        <meta name="debug-country-code" content="{{ $country_code ?? '' }}">
        <meta name="debug-is-ru" content="{{ (!empty($is_ru) && $is_ru) ? '1' : '0' }}">
    @endif

    <link href="/assets/css/loaders/loader-typing.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="/assets/css/theme.css" rel="stylesheet" type="text/css" media="all"/>

    @section('custom_css')
    @show

    <link rel="preload" as="font" href="/assets/fonts/Inter-UI-upright.var.woff2" type="font/woff2"
          crossorigin="anonymous">
    <link rel="preload" as="font" href="/assets/fonts/Inter-UI.var.woff2" type="font/woff2" crossorigin="anonymous">
    <meta name="yandex-verification" content="5dcecb7dc7fb9e14"/>
</head>


<body>
@section('sidebar')
    <div class="loader">
        <div class="loading-animation"></div>
    </div>
@show
@yield('content')

@php
    use App\Support\SiteLocale;

    $localizedHomeRoute = SiteLocale::routeNameForLocale('static_pages.home', $site_locale ?? 'ru');
    $localizedBlogRoute = SiteLocale::routeNameForLocale('blog.blog', $site_locale ?? 'ru');
    $localizedContactRoute = SiteLocale::routeNameForLocale('static_pages.contact', $site_locale ?? 'ru');
    $localizedTermsRoute = SiteLocale::routeNameForLocale('docs.terms_of_use', $site_locale ?? 'ru');
    $localizedAboutRoute = SiteLocale::routeNameForLocale('static_pages.about_me', $site_locale ?? 'ru');
    $localizedYaiRoute = SiteLocale::routeNameForLocale('static_pages.yai', $site_locale ?? 'ru');
    $termsUrl = route($localizedTermsRoute);
    $termsUrlWithSupport = $termsUrl . '#support';
@endphp
<footer class="bg-primary-alt">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col d-flex flex-column align-items-center align-items-md-start">
                <a href="{{ route($localizedHomeRoute) }}">
                    <span><h2>Ampleev.com</h2></span>
                </a>
                <ul class="nav mt-3">
                    <li class="nav-item">
                        <a href="{{ route($localizedBlogRoute) }}" class="nav-link pl-0 mr-2">{{ $locale_labels['blog'] }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route($localizedContactRoute) }}" class="nav-link pl-0 mr-2">{{ $locale_labels['contacts'] }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{$termsUrl}}" class="nav-link pl-0 mr-2">{{ $locale_labels['terms'] }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route($localizedAboutRoute) }}" class="nav-link pl-0 mr-2">{{ $locale_labels['about_me'] }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route($localizedYaiRoute) }}" class="nav-link pl-0 mr-2">{{ $locale_labels['yai'] }}</a>
                    </li>
                </ul>
                <small class="text-muted mt-2 d-none d-lg-block">{{ $locale_labels['copyright'] }}</small>
            </div>
            <div class="col-lg-5 col-md-6 mt-3 mt-lg-0">
                <form action="{{ route(SiteLocale::routeNameForLocale('blog.add_subscriber', $site_locale ?? 'ru')) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="d-none" aria-hidden="true">
                        <input type="text"
                               name="company_name"
                               value=""
                               tabindex="-1"
                               autocomplete="off">
                    </div>
                    <div class="form-row flex-column flex-md-row">
                        <div class="col">
                            <input type="email" class="form-control mb-2" placeholder="{{ $locale_labels['subscribe_placeholder'] }}" name="email" required>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary btn-loading btn-block" data-loading-text="Отправка">
                                <img class="icon" src="/assets/img/icons/theme/code/loading.svg" alt="loading icon" data-inject-svg/>
                                <span>{{ $locale_labels['subscribe'] }}</span>
                            </button>
                        </div>
                        <div class="col-12">
                            <div class="d-none alert alert-success" role="alert" data-success-message>
                                {{ $locale_labels['subscribe_success'] }}
                        </div>
                            <div class="d-none alert alert-danger" role="alert" data-error-message>
                                {{ $locale_labels['subscribe_error'] }}
            </div>
                            <div data-recaptcha data-sitekey="INSERT_YOUR_RECAPTCHA_V2_SITEKEY_HERE"
                                 data-size="invisible" data-badge="bottomleft">
            </div>
        </div>
            </div>
                </form>
                <small class="text-muted form-text">{{ $locale_labels['privacy_notice'] }} <a target="_blank"
                                                                                                         href="{{$termsUrl}}">{{ $locale_labels['terms_link'] }}</a> {{ $locale_labels['and'] }} <a
                        target="_blank"
                        href="{{$termsUrlWithSupport}}">{{ $locale_labels['privacy_link'] }}</a>
                </small>
            </div>
        </div>
    </div>
</footer>

<a href="#" class="btn back-to-top btn-primary btn-round" data-smooth-scroll data-aos="fade-up"
   data-aos-offset="2000"
   data-aos-mirror="true" data-aos-once="false">
    <img class="icon" src="/assets/img/icons/theme/navigation/arrow-up.svg" alt="arrow-up icon" data-inject-svg/>
</a>


<!-- Required vendor scripts (Do not remove) -->
<script type="text/javascript" src="/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/popper.min.js"></script>
<script type="text/javascript" src="/assets/js/bootstrap.js"></script>

<!-- Optional Vendor Scripts (Remove the plugin script here and comment initializer script out of index.js if site does not use that feature) -->

<!-- AOS (Animate On Scroll - animates elements into view while scrolling down) -->
<script type="text/javascript" src="/assets/js/aos.js"></script>
<!-- Clipboard (copies content from browser into OS clipboard) -->
<script type="text/javascript" src="/assets/js/clipboard.js"></script>
<!-- Fancybox (handles image and video lightbox and galleries) -->
<script type="text/javascript" src="/assets/js/jquery.fancybox.min.js"></script>
<!-- Flatpickr (calendar/date/time picker UI) -->
<script type="text/javascript" src="/assets/js/flatpickr.min.js"></script>
<!-- Flickity (handles touch enabled carousels and sliders) -->
<script type="text/javascript" src="/assets/js/flickity.pkgd.min.js"></script>
<!-- Ion rangeSlider (flexible and pretty range slider elements) -->
<script type="text/javascript" src="/assets/js/ion.rangeSlider.min.js"></script>
<!-- Isotope (masonry layouts and filtering) -->
<script type="text/javascript" src="/assets/js/isotope.pkgd.min.js"></script>
<!-- jarallax (parallax effect and video backgrounds) -->
<script type="text/javascript" src="/assets/js/jarallax.min.js"></script>
<script type="text/javascript" src="/assets/js/jarallax-video.min.js"></script>
<script type="text/javascript" src="/assets/js/jarallax-element.min.js"></script>
<!-- jQuery Countdown (displays countdown text to a specified date) -->
<script type="text/javascript" src="/assets/js/jquery.countdown.min.js"></script>
<!-- jQuery smartWizard facilitates steppable wizard content -->
<script type="text/javascript" src="/assets/js/jquery.smartWizard.min.js"></script>
<!-- Plyr (unified player for Video, Audio, Vimeo and Youtube) -->
<script type="text/javascript" src="/assets/js/plyr.polyfilled.min.js"></script>
<!-- Prism (displays formatted code boxes) -->
<script type="text/javascript" src="/assets/js/prism.js"></script>
<!-- ScrollMonitor (manages events for elements scrolling in and out of view) -->
<script type="text/javascript" src="/assets/js/scrollMonitor.js"></script>
<!-- Smooth scroll (animation to links in-page)-->
<script type="text/javascript" src="/assets/js/smooth-scroll.polyfills.min.js"></script>
<!-- SVGInjector (replaces img tags with SVG code to allow easy inclusion of SVGs with the benefit of inheriting colors and styles)-->
<script type="text/javascript" src="/assets/js/svg-injector.umd.production.js"></script>
<!-- TwitterFetcher (displays a feed of tweets from a specified account)-->
<script type="text/javascript" src="/assets/js/twitterFetcher_min.js"></script>
<!-- Typed text (animated typing effect)-->
<script type="text/javascript" src="/assets/js/typed.min.js"></script>
<!-- Required theme scripts (Do not remove) -->
<script type="text/javascript" src="/assets/js/theme.js"></script>
<!-- Removes page load animation when window is finished loading -->
<script type="text/javascript">
    window.addEventListener("load", function () {
        document.querySelector('body').classList.add('loaded');
    });
</script>
@if(app()->environment('production') && !$firstPartyAnalyticsDisabled)
    <script type="text/javascript">
        (function () {
            var endpoint = @json(route('site_page_visits.store', [], false));
            var csrfToken = document.querySelector('meta[name="csrf-token"]');
            var connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection || {};
            var screenInfo = window.screen || {};

            function boolValue(value) {
                return typeof value === 'boolean' ? value : null;
            }

            function intValue(value) {
                return Number.isFinite(value) ? Math.round(value) : null;
            }

            function numberValue(value) {
                return Number.isFinite(value) ? value : null;
            }

            function collectBasePayload() {
                var timezone = '';
                try {
                    timezone = Intl.DateTimeFormat().resolvedOptions().timeZone || '';
                } catch (e) {}

                var canonical = document.querySelector('link[rel="canonical"]');

                return {
                    page_url: window.location.href,
                    page_title: document.title || '',
                    canonical_url: canonical ? canonical.href : '',
                    locale: document.documentElement ? document.documentElement.lang : '',
                    referrer: document.referrer || '',
                    timezone: timezone,
                    timezone_offset: new Date().getTimezoneOffset(),
                    language: navigator.language || '',
                    languages: navigator.languages ? Array.prototype.slice.call(navigator.languages, 0, 20) : [],
                    platform: navigator.platform || '',
                    vendor: navigator.vendor || '',
                    cookie_enabled: boolValue(navigator.cookieEnabled),
                    do_not_track: navigator.doNotTrack || window.doNotTrack || navigator.msDoNotTrack || '',
                    screen_width: intValue(screenInfo.width),
                    screen_height: intValue(screenInfo.height),
                    available_width: intValue(screenInfo.availWidth),
                    available_height: intValue(screenInfo.availHeight),
                    viewport_width: intValue(window.innerWidth || document.documentElement.clientWidth || 0),
                    viewport_height: intValue(window.innerHeight || document.documentElement.clientHeight || 0),
                    device_pixel_ratio: numberValue(window.devicePixelRatio),
                    color_depth: intValue(screenInfo.colorDepth),
                    pixel_depth: intValue(screenInfo.pixelDepth),
                    max_touch_points: intValue(navigator.maxTouchPoints || 0),
                    hardware_concurrency: intValue(navigator.hardwareConcurrency),
                    device_memory: numberValue(navigator.deviceMemory),
                    connection_type: connection.type || '',
                    effective_connection_type: connection.effectiveType || '',
                    downlink: numberValue(connection.downlink),
                    rtt: intValue(connection.rtt),
                    save_data: boolValue(connection.saveData),
                    touch_supported: ('ontouchstart' in window) || (navigator.maxTouchPoints > 0),
                    standalone: Boolean(
                        (window.matchMedia && window.matchMedia('(display-mode: standalone)').matches)
                        || window.navigator.standalone
                    ),
                    visibility_state: document.visibilityState || '',
                    local_time: new Date().toString()
                };
            }

            function send(payload) {
                fetch(endpoint, {
                    method: 'POST',
                    credentials: 'same-origin',
                    keepalive: true,
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken ? csrfToken.getAttribute('content') : ''
                    },
                    body: JSON.stringify(payload)
                }).catch(function () {});
            }

            var payload = collectBasePayload();
            if (navigator.userAgentData && navigator.userAgentData.getHighEntropyValues) {
                navigator.userAgentData.getHighEntropyValues([
                    'architecture',
                    'bitness',
                    'brands',
                    'fullVersionList',
                    'mobile',
                    'model',
                    'platform',
                    'platformVersion',
                    'uaFullVersion',
                    'wow64'
                ]).then(function (hints) {
                    payload.user_agent_data = hints;
                    send(payload);
                }).catch(function () {
                    send(payload);
                });
                return;
            }

            if (navigator.userAgentData) {
                payload.user_agent_data = {
                    brands: navigator.userAgentData.brands || [],
                    mobile: navigator.userAgentData.mobile,
                    platform: navigator.userAgentData.platform
                };
            }

            send(payload);
        })();
    </script>
@endif
@if(app()->environment('production'))
    <script type="text/javascript">
        (function () {
            function hasCookie(name) {
                return document.cookie.split('; ').some(function (part) {
                    return part.indexOf(name + '=') === 0;
                });
            }

            if (!hasCookie('personal_link_visit_pending')) return;

            var endpoint = @json(route('personal_link_visits.enrich', [], false));
            var csrfToken = document.querySelector('meta[name="csrf-token"]');
            var connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection || {};
            var screenInfo = window.screen || {};

            function boolValue(value) {
                return typeof value === 'boolean' ? value : null;
            }

            function intValue(value) {
                return Number.isFinite(value) ? Math.round(value) : null;
            }

            function numberValue(value) {
                return Number.isFinite(value) ? value : null;
            }

            function clearPendingCookie() {
                document.cookie = 'personal_link_visit_pending=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT; samesite=lax';
            }

            function collectBasePayload() {
                var timezone = '';
                try {
                    timezone = Intl.DateTimeFormat().resolvedOptions().timeZone || '';
                } catch (e) {}

                return {
                    page_url: window.location.href,
                    referrer: document.referrer || '',
                    timezone: timezone,
                    timezone_offset: new Date().getTimezoneOffset(),
                    language: navigator.language || '',
                    languages: navigator.languages ? Array.prototype.slice.call(navigator.languages, 0, 20) : [],
                    platform: navigator.platform || '',
                    vendor: navigator.vendor || '',
                    cookie_enabled: boolValue(navigator.cookieEnabled),
                    do_not_track: navigator.doNotTrack || window.doNotTrack || navigator.msDoNotTrack || '',
                    screen_width: intValue(screenInfo.width),
                    screen_height: intValue(screenInfo.height),
                    available_width: intValue(screenInfo.availWidth),
                    available_height: intValue(screenInfo.availHeight),
                    viewport_width: intValue(window.innerWidth || document.documentElement.clientWidth || 0),
                    viewport_height: intValue(window.innerHeight || document.documentElement.clientHeight || 0),
                    device_pixel_ratio: numberValue(window.devicePixelRatio),
                    color_depth: intValue(screenInfo.colorDepth),
                    pixel_depth: intValue(screenInfo.pixelDepth),
                    max_touch_points: intValue(navigator.maxTouchPoints || 0),
                    hardware_concurrency: intValue(navigator.hardwareConcurrency),
                    device_memory: numberValue(navigator.deviceMemory),
                    connection_type: connection.type || '',
                    effective_connection_type: connection.effectiveType || '',
                    downlink: numberValue(connection.downlink),
                    rtt: intValue(connection.rtt),
                    save_data: boolValue(connection.saveData),
                    touch_supported: ('ontouchstart' in window) || (navigator.maxTouchPoints > 0),
                    standalone: Boolean(
                        (window.matchMedia && window.matchMedia('(display-mode: standalone)').matches)
                        || window.navigator.standalone
                    ),
                    visibility_state: document.visibilityState || '',
                    local_time: new Date().toString()
                };
            }

            function send(payload) {
                fetch(endpoint, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken ? csrfToken.getAttribute('content') : ''
                    },
                    body: JSON.stringify(payload)
                }).then(function (response) {
                    if (response.ok) {
                        clearPendingCookie();
                    }
                }).catch(function () {});
            }

            var payload = collectBasePayload();
            if (navigator.userAgentData && navigator.userAgentData.getHighEntropyValues) {
                navigator.userAgentData.getHighEntropyValues([
                    'architecture',
                    'bitness',
                    'brands',
                    'fullVersionList',
                    'mobile',
                    'model',
                    'platform',
                    'platformVersion',
                    'uaFullVersion',
                    'wow64'
                ]).then(function (hints) {
                    payload.user_agent_data = hints;
                    send(payload);
                }).catch(function () {
                    send(payload);
                });
                return;
            }

            if (navigator.userAgentData) {
                payload.user_agent_data = {
                    brands: navigator.userAgentData.brands || [],
                    mobile: navigator.userAgentData.mobile,
                    platform: navigator.userAgentData.platform
                };
            }

            send(payload);
        })();
    </script>
@endif
@section('pageScript')
@show
</body>
</html>
