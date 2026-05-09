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
        ]
        : [
            'title' => 'Обо мне',
            'description' => 'На данной странице вы получите исчерпывающую информацию обо мне',
            'badge' => 'Коротко',
            'heading' => 'Обо мне',
            'lead_1' => 'IT-менеджер с опытом в <code><b>FinTech</b></code>, крупном цифровом бизнесе и стартапах. Работаю с фокусом на ключевые бизнес-метрики: <code><b>Retention</b></code>, <code><b>LTV</b></code>, <code><b>P&L</b></code>, <code><b>TTM</b></code>. Имею опыт в управлении командами, запуске и развитии it-продуктов (CRM, мобильные приложения), системной работе над процессами (<code><b>Agile</b></code>-трансформации, разработка методологий).',
            'lead_2' => 'Сохраняю актуальную техническую экспертизу (<code><b>Go</b></code>, <code><b>Swift</b></code>, <code><b>JS</b></code>, <code><b>CI/CD</b></code>) и применяю <code><b>AI/ML</b></code>-технологии.',
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
                                <img src="{{ asset($companyLogo['logo']) }}" alt="{{ $companyLogo['company'] }}">
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
@endsection
