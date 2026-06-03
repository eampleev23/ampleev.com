@php
    use App\Support\SiteLocale;

    $currentLocale = $site_locale ?? 'ru';
    $aboutCompanyRoute = SiteLocale::routeNameForLocale('static_pages.about_company', $currentLocale);
    $homeRoute = SiteLocale::routeNameForLocale('static_pages.home', $currentLocale);
    $aboutCompanyRuUrl = route('static_pages.about_company');
    $aboutCompanyEnUrl = route('en.static_pages.about_company');
    $locale_switch_urls = [
        'ru' => $aboutCompanyRuUrl,
        'en' => $aboutCompanyEnUrl,
    ];
    $copy = $currentLocale === 'en'
        ? [
            'title' => 'About Company',
            'description' => 'Information about the company and the team.',
            'home' => 'Home',
            'pages' => 'Pages',
            'company' => 'About Company',
            'hero_heading' => 'About us',
            'hero_lead' => 'A placeholder company page that is now ready for a proper English version as well.',
            'numbers' => 'At a glance',
            'users' => 'Monthly active users',
            'team' => 'Team members',
            'projects' => 'Published projects',
            'uptime' => '% Uptime',
            'mission_badge' => 'Our mission',
            'mission_heading' => 'Change the game through design',
            'mission_lead' => 'This page still contains generic demo content, but the EN route and SEO structure are now in place.',
            'mission_body' => 'We can replace this placeholder copy with real company information later without changing the routing model.',
            'leaders' => 'Leadership team',
            'designer' => 'Designer',
            'history' => 'Our story',
            'series_a' => 'Series A funding secured',
            'cto' => 'New CTO: Name Surname',
            'v1' => 'Version 1.0 launched',
            'wired' => 'Featured in Wired',
            'v2' => 'Version 2.0 launched',
        ]
        : [
            'title' => 'О компании',
            'description' => 'Информация о компании и команде',
            'home' => 'Главная',
            'pages' => 'Страницы',
            'company' => 'О компании',
            'hero_heading' => 'О нас',
            'hero_lead' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa.',
            'numbers' => 'В цифрах',
            'users' => 'Активных пользователей в месяц',
            'team' => 'Членов команды',
            'projects' => 'Опубликованных проектов',
            'uptime' => '% Время работы сервера',
            'mission_badge' => 'Наша миссия',
            'mission_heading' => 'Изменить игру через дизайн',
            'mission_lead' => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati.',
            'mission_body' => 'Cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.',
            'leaders' => 'Команда лидеров',
            'designer' => 'Дизайнер',
            'history' => 'Наша история',
            'series_a' => 'Получено финансирование Series-A',
            'cto' => 'Новый CTO: Имя Фамилия',
            'v1' => 'Выход версии 1.0',
            'wired' => 'Упоминание в Wired',
            'v2' => 'Выход версии 2.0',
        ];
@endphp

@extends('layouts.app')

@section('title', $copy['title'])
@section('description', $copy['description'])
@section('page_url', route($aboutCompanyRoute))
@section('canonical_url', route($aboutCompanyRoute))
@section('alternate_url_ru', $aboutCompanyRuUrl)
@section('alternate_url_en', $aboutCompanyEnUrl)
@section('x_default_url', $aboutCompanyEnUrl)

@section('custom_css')
    @parent
@endsection

@section('sidebar')
    @parent
    <link href="assets/css/custom.css?v={{ filemtime(public_path('assets/css/custom.css')) }}" rel="stylesheet"
          type="text/css" media="all"/>
@endsection

@section('content')
    @include('layouts.navbar')

    <!-- Hero Section -->
    <section class="has-divider text-light jarallax bg-dark" data-jarallax data-speed="0.5" data-overlay>
                        <img src="assets/img/inner-1.jpg" alt="Image" class="jarallax-img opacity-50">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-xl-8 col-lg-10">
                    <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                        <ol class="breadcrumb breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ route($homeRoute) }}">{{ $copy['home'] }}</a></li>
                            <li class="breadcrumb-item"><a href="#">{{ $copy['pages'] }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $copy['company'] }}</li>
                        </ol>
                    </nav>
                    <h1 data-aos="fade-up" data-aos-delay="200">{{ $copy['hero_heading'] }}</h1>
                    <p class="lead" data-aos="fade-up" data-aos-delay="300">
                        {{ $copy['hero_lead'] }}
                    </p>
                </div>
            </div>
        </div>
        <div class="divider">
            <img src="assets/img/dividers/divider-2.svg" alt="graphical divider" data-inject-svg />
        </div>
    </section>

    <!-- At a glance Section -->
    <section class="bg-primary-3 text-light">
        <div class="container">
            <div class="row mb-4">
                <div class="col">
                    <h2 class="mb-4" data-aos="fade-up">{{ $copy['numbers'] }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-3 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-center">
                        <div class="h1 mb-2" data-countup="" data-start="0" data-end="50000" data-duration="2" data-easing="true">0</div>
                        <div class="text-small">{{ $copy['users'] }}</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-center">
                        <div class="h1 mb-2" data-countup="" data-start="0" data-end="120" data-duration="2" data-easing="true">0</div>
                        <div class="text-small">{{ $copy['team'] }}</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-center">
                        <div class="h1 mb-2" data-countup="" data-start="0" data-end="15000" data-duration="2" data-easing="true">0</div>
                        <div class="text-small">{{ $copy['projects'] }}</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="400">
                    <div class="text-center">
                        <div class="h1 mb-2" data-countup="" data-start="0" data-end="99" data-duration="2" data-easing="true">0</div>
                        <div class="text-small">{{ $copy['uptime'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="row align-items-center justify-content-around">
                        <div class="col-md-6 col-xl-5 mb-4 mb-md-0" data-aos="fade-right">
                            <img src="assets/img/inner-2.jpg" alt="Image" class="rounded shadow-3d">
                        </div>
                        <div class="col-md-6 col-xl-5" data-aos="fade-left">
                            <div class="mb-4">
                                <span class="badge badge-primary">{{ $copy['mission_badge'] }}</span>
                                <h2 class="mt-2">{{ $copy['mission_heading'] }}</h2>
                            </div>
                            <p class="lead">
                                {{ $copy['mission_lead'] }}
                            </p>
                            <p>
                                {{ $copy['mission_body'] }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Leadership Team Section -->
    <section class="bg-primary-3 text-light">
        <div class="container">
            <div class="row mb-4">
                <div class="col">
                    <h2 class="mb-4" data-aos="fade-up">{{ $copy['leaders'] }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card card-body bg-primary text-light">
                        <div class="mb-3">
                            <img src="assets/img/avatars/male-1.jpg" alt="Avatar" class="avatar avatar-lg">
                        </div>
                        <h5>Имя Фамилия</h5>
                        <span class="text-small text-muted">CEO</span>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card card-body bg-primary text-light">
                        <div class="mb-3">
                            <img src="assets/img/avatars/male-2.jpg" alt="Avatar" class="avatar avatar-lg">
                        </div>
                        <h5>Имя Фамилия</h5>
                        <span class="text-small text-muted">CTO</span>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card card-body bg-primary text-light">
                        <div class="mb-3">
                            <img src="assets/img/avatars/female-1.jpg" alt="Avatar" class="avatar avatar-lg">
                        </div>
                        <h5>Имя Фамилия</h5>
                        <span class="text-small text-muted">{{ $copy['designer'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- History Section -->
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="row mb-4">
                        <div class="col">
                            <h2 data-aos="fade-up">{{ $copy['history'] }}</h2>
                        </div>
                    </div>
                    <ol class="process-vertical">
                        <li data-aos="fade-left" data-aos-delay="100">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Октябрь 2016</span>
                                <h5>{{ $copy['series_a'] }}</h5>
                            </div>
                        </li>
                        <li data-aos="fade-left" data-aos-delay="200">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Апрель 2017</span>
                                <h5>{{ $copy['cto'] }}</h5>
                            </div>
                        </li>
                        <li data-aos="fade-left" data-aos-delay="300">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Октябрь 2017</span>
                                <h5>{{ $copy['v1'] }}</h5>
                            </div>
                        </li>
                        <li data-aos="fade-left" data-aos-delay="400">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Февраль 2018</span>
                                <h5>{{ $copy['wired'] }}</h5>
                            </div>
                        </li>
                        <li data-aos="fade-left" data-aos-delay="500">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Сентябрь 2018</span>
                                <h5>{{ $copy['v2'] }}</h5>
                            </div>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('pageScript')
    @parent
    <script>
        // Инициализация счетчиков при загрузке страницы
        document.addEventListener('DOMContentLoaded', function() {
            // AOS и другие скрипты уже подключены через theme.js
        });
    </script>
@endsection
