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

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (m, e, t, r, i, k, a) {
            m[i] = m[i] || function () {
                (m[i].a = m[i].a || []).push(arguments)
            };
            m[i].l = 1 * new Date();
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
        })
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(57345031, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true
        });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/57345031" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->

    <meta charset="utf-8">

    <title>@yield('title') | Амплеев Евгений - Agile Coach / Full stack web developer. Персональный блог.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description')Персональный блог.">

    <meta property="og:url"
          content="@yield('page_url')"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="@yield('title') | Амплеев Евгений - Agile Coach / Full stack web developer"/>
    <meta property="og:description" content="@yield('description')Персональный блог."/>
    <meta property="og:image" content="@yield('main_image_path')"/>

    <link href="assets/css/loaders/loader-typing.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="assets/css/theme.css" rel="stylesheet" type="text/css" media="all"/>

    @section('custom_css')
    @show

    <link rel="preload" as="font" href="assets/fonts/Inter-UI-upright.var.woff2" type="font/woff2"
          crossorigin="anonymous">
    <link rel="preload" as="font" href="assets/fonts/Inter-UI.var.woff2" type="font/woff2" crossorigin="anonymous">
    <meta name="yandex-verification" content="5dcecb7dc7fb9e14"/>
</head>


<body>
@section('sidebar')
    <div class="loader">
        <div class="loading-animation"></div>
    </div>
@show
@yield('content')

<footer class="pb-4 bg-primary-3 text-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col">
                <a href="{{route('blog.home')}}">
                    <span><h2>Ampleev.com</h2></span>
                </a>
                <p class="pr-xl-3">
                    Персональный блог
                </p>

                @if (!$last_articles[0]->isMobile())
                    @include('layouts.menu_items_footer')
                @endif

            </div>
            <div class="col-6 col-lg">
                <h5>Контакты</h5>
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex">
                        <img class="icon" src="assets/img/icons/theme/map/marker-1.svg" alt="marker-1 icon"
                             data-inject-svg/>
                        <div class="ml-3">
                  <span>10 Паршина
                    <br/>Москва</span>
                        </div>
                    </li>
                    <li class="mb-3 d-flex">
                        <img class="icon" src="assets/img/icons/theme/communication/call-1.svg" alt="call-1 icon"
                             data-inject-svg/>
                        <div class="ml-3">
                            <span>+79 2613 82009</span>
                            <span class="d-block text-muted text-small">Пн - Пт 9am - 5pm</span>
                        </div>
                    </li>
                    <li class="mb-3 d-flex">
                        <img class="icon" src="assets/img/icons/theme/communication/mail.svg" alt="mail icon"
                             data-inject-svg/>
                        <div class="ml-3">
                            <a href="#">e@mpleev.com</a>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="col-6 col-lg-3">
                {{--                @if (!$last_articles[0]->isMobile())--}}
                {{--                    <h5>Популярное</h5>--}}
                {{--                    <ul class="list-unstyled list-articles">--}}
                {{--                        @for($i=0; $i < count($last_articles); $i++)--}}
                {{--                            <li class="row row-tight">--}}
                {{--                                <a href="{{route('blog.show_article',$last_articles[$i]->text_url)}}" class="col-3">--}}
                {{--                                    <img src="{{$last_articles[$i]->main_image_path}}" alt="Image" class="rounded">--}}
                {{--                                </a>--}}
                {{--                                <div class="col">--}}
                {{--                                    <a href="{{route('blog.show_article',$last_articles[$i]->text_url)}}">--}}
                {{--                                        <h6 class="mb-1">{{$last_articles[$i]->title}}</h6>--}}
                {{--                                    </a>--}}
                {{--                                    <div class="d-flex text-small">--}}
                {{--                                        <a href="{{route('blog.show_blog_section',$last_articles[$i]->blog_section->title)}}">{{$last_articles[$i]->blog_section->title}}</a>--}}
                {{--                                        <span--}}
                {{--                                            class="text-muted ml-1">{{$last_articles[$i]->get_nice_time_created()}}</span>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </li>--}}
                {{--                        @endfor--}}
                {{--                    </ul>--}}
                {{--                @endif--}}
            </div>
        </div>
        <div class="row justify-content-center mb-2">
            <div class="col-auto">
                <ul class="nav">
                    <li class="nav-item">
                        <a href="https://www.instagram.com/mpleeve/" class="nav-link">
                            {{--                            <img class="icon undefined" src="assets/img/icons/social/instagram.svg"--}}
                            {{--                                 alt="instagram social icon" data-inject-svg/>--}}

                            <img class="icon undefined" src="assets/my_svg/inst.svg"
                                 alt="instagram social icon" data-inject-svg/>
                        </a>
                    </li>
                    <li class="nav-item">
                        {{--                        <a href="https://twitter.com/ampleevE"--}}
                        {{--                           class="nav-link fix_padding_social">--}}
                        {{--                            <img class="icon undefined" src="assets/img/icons/social/twitter.svg"--}}
                        {{--                                 alt="twitter social icon" data-inject-svg/>--}}
                        {{--                        </a>--}}
                        <a href="https://x.com/ampleevE"
                           class="nav-link fix_padding_social" style="margin-left: -17px;">
                            <img class="icon undefined" src="assets/img/x-social.svg"
                                 alt="x social icon" data-inject-svg/>
                        </a>
                    </li>
                    {{--                    <li class="nav-item">--}}
                    {{--                        <a href="#" class="nav-link">--}}
                    {{--                            <img class="icon undefined" src="assets/img/icons/social/youtube.svg"--}}
                    {{--                                 alt="youtube social icon" data-inject-svg/>--}}
                    {{--                        </a>--}}
                    {{--                    </li>--}}
                    {{--                    <li class="nav-item">--}}
                    {{--                        <a href="#" class="nav-link">--}}
                    {{--                            <img class="icon undefined" src="assets/img/icons/social/medium.svg"--}}
                    {{--                                 alt="medium social icon" data-inject-svg/>--}}
                    {{--                        </a>--}}
                    {{--                    </li>--}}
                    <li class="nav-item">
                        <a href="https://www.facebook.com/eampleev"
                           class="nav-link fix_padding_social">
                            <img class="icon undefined" src="assets/img/icons/social/facebook.svg"
                                 alt="facebook social icon" data-inject-svg/>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col col-md-auto text-center">
                <small class="text-muted">&copy;2010-2021 Все права сохранены. Ampleev.com®
                </small>
            </div>
        </div>
    </div>
</footer>

<a href="#" class="btn back-to-top btn-primary btn-round" data-smooth-scroll data-aos="fade-up"
   data-aos-offset="2000"
   data-aos-mirror="true" data-aos-once="false">
    <img class="icon" src="assets/img/icons/theme/navigation/arrow-up.svg" alt="arrow-up icon" data-inject-svg/>
</a>


<!-- Required vendor scripts (Do not remove) -->
<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/popper.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.js"></script>

<!-- Optional Vendor Scripts (Remove the plugin script here and comment initializer script out of index.js if site does not use that feature) -->

<!-- AOS (Animate On Scroll - animates elements into view while scrolling down) -->
<script type="text/javascript" src="assets/js/aos.js"></script>
<!-- Clipboard (copies content from browser into OS clipboard) -->
<script type="text/javascript" src="assets/js/clipboard.js"></script>
<!-- Fancybox (handles image and video lightbox and galleries) -->
<script type="text/javascript" src="assets/js/jquery.fancybox.min.js"></script>
<!-- Flatpickr (calendar/date/time picker UI) -->
<script type="text/javascript" src="assets/js/flatpickr.min.js"></script>
<!-- Flickity (handles touch enabled carousels and sliders) -->
<script type="text/javascript" src="assets/js/flickity.pkgd.min.js"></script>
<!-- Ion rangeSlider (flexible and pretty range slider elements) -->
<script type="text/javascript" src="assets/js/ion.rangeSlider.min.js"></script>
<!-- Isotope (masonry layouts and filtering) -->
<script type="text/javascript" src="assets/js/isotope.pkgd.min.js"></script>
<!-- jarallax (parallax effect and video backgrounds) -->
<script type="text/javascript" src="assets/js/jarallax.min.js"></script>
<script type="text/javascript" src="assets/js/jarallax-video.min.js"></script>
<script type="text/javascript" src="assets/js/jarallax-element.min.js"></script>
<!-- jQuery Countdown (displays countdown text to a specified date) -->
<script type="text/javascript" src="assets/js/jquery.countdown.min.js"></script>
<!-- jQuery smartWizard facilitates steppable wizard content -->
<script type="text/javascript" src="assets/js/jquery.smartWizard.min.js"></script>
<!-- Plyr (unified player for Video, Audio, Vimeo and Youtube) -->
<script type="text/javascript" src="assets/js/plyr.polyfilled.min.js"></script>
<!-- Prism (displays formatted code boxes) -->
<script type="text/javascript" src="assets/js/prism.js"></script>
<!-- ScrollMonitor (manages events for elements scrolling in and out of view) -->
<script type="text/javascript" src="assets/js/scrollMonitor.js"></script>
<!-- Smooth scroll (animation to links in-page)-->
<script type="text/javascript" src="assets/js/smooth-scroll.polyfills.min.js"></script>
<!-- SVGInjector (replaces img tags with SVG code to allow easy inclusion of SVGs with the benefit of inheriting colors and styles)-->
<script type="text/javascript" src="assets/js/svg-injector.umd.production.js"></script>
<!-- TwitterFetcher (displays a feed of tweets from a specified account)-->
<script type="text/javascript" src="assets/js/twitterFetcher_min.js"></script>
<!-- Typed text (animated typing effect)-->
<script type="text/javascript" src="assets/js/typed.min.js"></script>
<!-- Required theme scripts (Do not remove) -->
<script type="text/javascript" src="assets/js/theme.js"></script>
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
