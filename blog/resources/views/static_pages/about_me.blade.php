@php
    use App\Support\SiteLocale;

    $currentLocale = $site_locale ?? 'ru';
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
            'lead_1' => 'IT manager with experience in <code><b>FinTech</b></code>, large digital businesses, and startups. I work with a strong focus on business metrics such as <code><b>Retention</b></code>, <code><b>LTV</b></code>, <code><b>P&L</b></code>, and <code><b>TTM</b></code>. I have experience leading teams, launching and scaling IT products (CRM, mobile apps), and improving delivery processes through <code><b>Agile</b></code> transformations and internal methodologies.',
            'lead_2' => 'I keep my technical expertise current in <code><b>Go</b></code>, <code><b>Swift</b></code>, <code><b>JS</b></code>, and <code><b>CI/CD</b></code>, and actively apply <code><b>AI/ML</b></code> technologies in practice.',
        ]
        : [
            'title' => 'Обо мне',
            'description' => 'На данной странице вы получите исчерпывающую информацию обо мне',
            'badge' => 'Коротко',
            'heading' => 'Обо мне',
            'lead_1' => 'IT-менеджер с опытом в <code><b>FinTech</b></code>, крупном цифровом бизнесе и стартапах. Работаю с фокусом на ключевые бизнес-метрики: <code><b>Retention</b></code>, <code><b>LTV</b></code>, <code><b>P&L</b></code>, <code><b>TTM</b></code>. Имею опыт в управлении командами, запуске и развитии it-продуктов (CRM, мобильные приложения), системной работе над процессами (<code><b>Agile</b></code>-трансформации, разработка методологий).',
            'lead_2' => 'Сохраняю актуальную техническую экспертизу (<code><b>Go</b></code>, <code><b>Swift</b></code>, <code><b>JS</b></code>, <code><b>CI/CD</b></code>) и применяю <code><b>AI/ML</b></code>-технологии.',
        ];
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
    <section class="has-divider text-light jarallax bg-dark" data-jarallax data-speed="0.5" data-overlay>
    </section>

    <section>
        <div class="container aos-init aos-animate" data-aos="fade-up">
            <div class="row align-items-center justify-content-around">
                <div class="col-md-5 col-xl-6 mb-4 mb-md-0">
                    <img src="{{ asset('assets/img/about_me_11_03.PNG') }}" alt="Image" class="rounded shadow-3d">
                </div>
                {{--                init commit --}}
                <div class="col-md-7 col-xl-6">
                    <div class="row justify-content-center">
                        <div class="col-xl-8 col-lg-10">
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

    {{-- Блок карьеры скрыт
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="row mb-4">
                        <div class="col">
                            <h2 data-aos="fade-up">Карьера</h2>
                        </div>
                    </div>
                    <ol class="process-vertical">
                        <li data-aos="fade-left" data-aos-delay="100">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Февраль 2024</span>
                                <h5><a href="https://www.gazprombank.ru">Газпромбанк</a></h5>
                                <h4>Исполнительный директор</h4>
                            </div>
                        </li>
                        <li data-aos="fade-left" data-aos-delay="300">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Февраль 2021</span>
                                <h5><a href="https://www.vtb.ru/">ВТБ</a></h5>
                                <h4>Agile-coach</h4>
                            </div>
                        </li>
                        <li data-aos="fade-left" data-aos-delay="400">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Февраль 2019</span>
                                <h5><a href="https://www.ingos.ru">Ингосстрах</a></h5>
                                <h4>Scrum Master</h4>
                            </div>
                        </li>
                        <li data-aos="fade-left" data-aos-delay="500">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Ноябрь 2015</span>
                                <h5><a href="https://alfabank.ru">Альфа Банк</a></h5>
                                <h4>Web Site менеджер</h4>
                            </div>
                        </li>
                        <li data-aos="fade-left" data-aos-delay="600">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Октябрь 2010</span>
                                <h5><a href="https://fom.ru">Фонд Общественное Мнение</a></h5>
                                <h4>Старший менеджер проектов</h4>
                            </div>
                        </li>
                        <li data-aos="fade-left" data-aos-delay="700">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Июнь 2010</span>
                                <h5><a href="https://fvt.pnzgu.ru">ФВТ ПГУ</a></h5>
                                <h4>Инженер-программист</h4>
                            </div>
                        </li>
                        <li data-aos="fade-left" data-aos-delay="600">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Май 2007</span>
                                <h5><a href="https://ampleev.com/">Ampleev.com</a></h5>
                                <h4>Индивидуальный предприниматель (web, mobile)</h4>
                            </div>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    --}}
@endsection

@section('pageScript')
    @parent
@endsection
