<!doctype html>
<html lang="ru">

<head>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#0071ff">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <!-- Favicon -->

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-12999557-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-12999557-2');
    </script>

    @php
        // Отключение Метрики для текущего браузера (чтобы исключить собственные визиты из статистики):
        // - Добавь ?metrika=off к любому URL → Метрика отключится (и поставится cookie metrika_disabled=1)
        // - Добавь ?metrika=on → Метрика включится обратно (cookie будет очищен)
        $metrikaQuery = request()->query('metrika');
        $metrikaDisabled = $metrikaQuery === 'off' || ($metrikaQuery !== 'on' && request()->cookie('metrika_disabled') === '1');
        $metrikaId = 57345031;
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

    @if(app()->environment('production') && !$metrikaDisabled)
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

    <title>@yield('title') | Амплеев Евгений</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description') Персональный блог.">

    <link rel="canonical" href="@yield('page_url')">

    <meta property="og:url"
          content="@yield('page_url')"/>
    <meta property="og:type" content="article"/>
    <meta property="og:site_name" content="Ampleev.com"/>
    <meta property="og:locale" content="ru_RU"/>
    <meta property="og:title" content="@yield('title') | Амплеев Евгений"/>
    <meta property="og:description" content="@yield('description')"/>
    <meta property="og:image" content="@yield('main_image_path')"/>
    <meta property="og:image:secure_url" content="@yield('main_image_path')"/>
    <meta property="og:image:alt" content="@yield('title')"/>
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:title" content="@yield('title') | Амплеев Евгений"/>
    <meta name="twitter:description" content="@yield('description')"/>
    <meta name="twitter:image" content="@yield('main_image_path')"/>
    <meta name="twitter:image:alt" content="@yield('title')"/>

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
    $termsUrl = route('docs.terms_of_use');
    $termsUrlWithSupport = $termsUrl . '#support';
    $isPointscounterSubdomain = request()->getHost() === 'pointscounter.ampleev.com';
@endphp
<footer class="bg-primary-alt">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col d-flex flex-column align-items-center align-items-md-start">
                <a href="{{route('static_pages.home')}}">
                    <span><h2>Ampleev.com</h2></span>
                </a>
                <ul class="nav mt-3">
                    @if($isPointscounterSubdomain)
                        {{-- Специальное меню для поддомена pointscounter.ampleev.com --}}
                        <li class="nav-item">
                            <a href="{{route('static_pages.contact')}}" class="nav-link pl-0 mr-2">Контакты</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('pointscounter.privacy')}}" class="nav-link pl-0 mr-2">Политика конфиденциальности</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{route('blog.blog')}}" class="nav-link pl-0 mr-2">Блог</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('static_pages.contact')}}" class="nav-link pl-0 mr-2">Контакты</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{$termsUrl}}" class="nav-link pl-0 mr-2">Правила</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('static_pages.about_me')}}" class="nav-link pl-0 mr-2">Обо мне</a>
                        </li>
                        @if(isset($active_menu_item) && $active_menu_item === 'Продукты')
                            <li class="nav-item">
                                <a href="{{route('pointscounter.privacy')}}" class="nav-link pl-0 mr-2">Политика конфиденциальности</a>
                            </li>
                        @endif
                    @endif
                </ul>
                <small class="text-muted mt-2 d-none d-lg-block">&copy;2010-2026 Все права сохранены. Ampleev.com®</small>
            </div>
            <div class="col-lg-5 col-md-6 mt-3 mt-lg-0">
                <form action="{{route('blog.add_subscriber')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row flex-column flex-md-row">
                        <div class="col">
                            <input type="email" class="form-control mb-2" placeholder="Email" name="email" required>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary btn-loading btn-block" data-loading-text="Отправка">
                                <img class="icon" src="/assets/img/icons/theme/code/loading.svg" alt="loading icon" data-inject-svg/>
                                <span>Подписаться</span>
                            </button>
                        </div>
                        <div class="col-12">
                            <div class="d-none alert alert-success" role="alert" data-success-message>
                                Спасибо за ваш интерес, мы отправили вам на почту ссылку для подтверждения. Она актуальна в течение 24 часов.
                            </div>
                            <div class="d-none alert alert-danger" role="alert" data-error-message>
                                Пожалуйста, используйте валидный email.
                            </div>
                            <div data-recaptcha data-sitekey="INSERT_YOUR_RECAPTCHA_V2_SITEKEY_HERE"
                                 data-size="invisible" data-badge="bottomleft">
                            </div>
                        </div>
                    </div>
                </form>
                <small class="text-muted form-text">Мы никогда не раскроем ваши данные. Смотрите наши <a target="_blank"
                                                                                                         href="{{$termsUrl}}">Пользовательское
                        соглашение</a> и <a
                        target="_blank"
                        href="{{$termsUrlWithSupport}}">Политику Конфиденциальности</a>
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
@section('pageScript')
@show
</body>
</html>
