@extends('layouts.app')

@section('title', 'Резюме - Руководитель IT-направления')
@section('description', 'Амплеев Евгений Михайлович - IT-эксперт с 19 летним опытом)
@section('page_url', route('static_pages.cv'))

@section('custom_css')
    @parent
@endsection

@section('sidebar')
    @parent
    <link href="assets/css/custom.css?v={{ filemtime(public_path('assets/css/custom.css')) }}" rel="stylesheet" type="text/css" media="all"/>
@endsection

@section('content')
    @include('layouts.navbar')

    <section class="bg-dark text-light header-inner p-0 jarallax o-hidden" data-overlay="" data-jarallax="" data-speed="0.2" style="padding-top: 69.2656px !important;">
        <div class="container py-0 layer-2">
            <div class="row my-3">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('blog.blog')}}">Блог</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Резюме</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row my-4 my-md-6 aos-init aos-animate" data-aos="fade-up">
                <div class="col-lg-9 col-xl-8">
                    <h1 class="display-4">Евгений Амплеев</h1>
                    <p class="lead mb-0">Руководитель IT-направления / Директор по разработке</p>
                </div>
            </div>
        </div>
        <div class="decoration-wrapper">
            <div class="decoration bottom right d-none d-md-block" data-jarallax-element="100 100" style="z-index: 0;">
                <img class="bg-primary-2" src="" alt="deco-blob-1 decoration" data-inject-svg="">
            </div>
        </div>
        <div class="divider flip-x">
            <img src="" alt="graphical divider" data-inject-svg="">
        </div>
    </section>

    <section class="bg-primary-alt">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <!-- Контакты -->
                    <div class="row mb-5">
                        <div class="col">
                            <h2 class="h3 mb-4">Контакты</h2>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card card-body shadow-1 bg-white">
                                        <strong>Телефон:</strong><br>
                                        +7 995 783-22-77
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card card-body shadow-1 bg-white">
                                        <strong>Email:</strong><br>
                                        e@mpleev.com
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card card-body shadow-1 bg-white">
                                        <strong>Telegram:</strong><br>
                                        @mpleeve
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ключевая экспертиза -->
                    <div class="row mb-5">
                        <div class="col">
                            <h2 class="h3 mb-4">Ключевая экспертиза</h2>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="card card-body shadow-1 bg-white h-100">
                                        <h5 class="text-primary">IT-лидерство</h5>
                                        <p class="mb-0">17+ лет управления разработкой и продуктами в финансовом секторе и IT. Ответственность за P&L направлений</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card card-body shadow-1 bg-white h-100">
                                        <h5 class="text-primary">Бизнес-трансформация</h5>
                                        <p class="mb-0">Специализация на Agile-трансформации предприятий. Перевод 10+ команд с Waterfall на Scrum/SAFe</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card card-body shadow-1 bg-white h-100">
                                        <h5 class="text-primary">Управление продуктом</h5>
                                        <p class="mb-0">Запуск и масштабирование B2B/B2C продуктов (CRM, мобильные приложения, веб-сервисы) с измеримым ростом доходов</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card card-body shadow-1 bg-white h-100">
                                        <h5 class="text-primary">Техническая стратегия</h5>
                                        <p class="mb-0">Глубокое понимание full-stack разработки (Go, Swift, JavaScript) для принятия архитектурных решений</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ключевые достижения -->
                    <div class="row mb-5">
                        <div class="col">
                            <h2 class="h3 mb-4">Ключевые достижения</h2>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex">
                                        <div class="mr-3">
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <span class="text-white">✓</span>
                                            </div>
                                        </div>
                                        <div>
                                            <strong>Рост доходов компании</strong>
                                            <p class="mb-0 text-muted">через фокус на бизнес-критичных направлениях</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex">
                                        <div class="mr-3">
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <span class="text-white">✓</span>
                                            </div>
                                        </div>
                                        <div>
                                            <strong>Agile-трансформация</strong>
                                            <p class="mb-0 text-muted">в 3+ крупных банках с построением скрам-команд и методологий</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex">
                                        <div class="mr-3">
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <span class="text-white">✓</span>
                                            </div>
                                        </div>
                                        <div>
                                            <strong>Запуск CRM-системы</strong>
                                            <p class="mb-0 text-muted">с нуля, обслуживающей 50+ продающих страниц и 3 интернет-магазина</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex">
                                        <div class="mr-3">
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <span class="text-white">✓</span>
                                            </div>
                                        </div>
                                        <div>
                                            <strong>Построение систем KPI</strong>
                                            <p class="mb-0 text-muted">и мотивации для команд управления рисками в крупном банке</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <!-- Ключевой опыт -->
                    <h2 class="h3 mb-5 text-center">Ключевой опыт</h2>

                    <div class="row">
                        <div class="col-12">
                            <!-- Главный эксперт -->
                            <div class="card card-body shadow-1 mb-4" data-aos="fade-up">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h4 class="text-primary mb-1">Главный эксперт по методологии разработки</h4>
                                        <p class="text-muted mb-2">Ноябрь 2024 — Сентябрь 2025 (11 месяцев)</p>
                                    </div>
                                </div>
                                <ul class="mb-0">
                                    <li>Построил AS IS-модель процессов разработки для аэропорта → выявил 20+ проблемных зон → разработал целевую методологию</li>
                                    <li>Согласовал требования 15+ стейкхолдеров → описал стандартизированные процессы разработки и поддержки ПО</li>
                                </ul>
                            </div>

                            <!-- Исполнительный директор -->
                            <div class="card card-body shadow-1 mb-4" data-aos="fade-up" data-aos-delay="100">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h4 class="text-primary mb-1">Исполнительный директор</h4>
                                        <p class="text-muted mb-2">Газпромбанк | Февраль 2024 — Сентябрь 2024 (8 месяцев)</p>
                                    </div>
                                </div>
                                <ul class="mb-0">
                                    <li>Разработал и внедрил систему KPI для команд управления рисками → повысил прозрачность оценки эффективности</li>
                                    <li>Создал методику расчета бизнес-эффектов от квартальных целей → ускорил принятие решений по премированию на 2 недели</li>
                                    <li>Разработал единую систему оценки сложности проектов → стандартизировал планирование для 10+ команд</li>
                                </ul>
                            </div>

                            <!-- Agile Coach -->
                            <div class="card card-body shadow-1 mb-4" data-aos="fade-up" data-aos-delay="200">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h4 class="text-primary mb-1">Agile Coach</h4>
                                        <p class="text-muted mb-2">Банк ВТБ | Февраль 2021 — Сентябрь 2023 (2 года 8 месяцев)</p>
                                    </div>
                                </div>
                                <ul class="mb-0">
                                    <li>Провел Agile-трансформацию розничного блока (зарплатные сервисы, виртуальные ассистенты) → увеличил скорость выпуска релизов на 25%</li>
                                    <li>Развивал школу скрам-мастеров → подготовил 90+ сертифицированных специалистов</li>
                                    <li>Разработал универсальную методику диагностирования стримов</li>
                                </ul>
                            </div>

                            <!-- Главный менеджер продукта -->
                            <div class="card card-body shadow-1 mb-4" data-aos="fade-up" data-aos-delay="300">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h4 class="text-primary mb-1">Главный менеджер продукта (сайт и CRM)</h4>
                                        <p class="text-muted mb-2">markethot.ru | Февраль 2015 — Март 2023 (8 лет 2 месяца)</p>
                                    </div>
                                </div>
                                <ul class="mb-0">
                                    <li>Управлял 3 скрам-командами (25+ человек) → перевел с Waterfall на Scrum → увеличил скорость разработки в 2 раза</li>
                                    <li>Запустил CRM-систему с нуля → автоматизировал работу 50+ продающих страниц и 3 интернет-магазинов</li>
                                    <li>Реализовал мобильное приложение для склада → сократил время сборки заказов на 35%</li>
                                    <li><strong>Результат:</strong> существенный рост доходов компании через концентрацию на бизнес-важных направлениях</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Ранний опыт -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <h3 class="h4 mb-4">Ранний опыт</h3>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card card-body text-center bg-light">
                                        <strong>ИП Амплеев</strong>
                                        <p class="text-muted mb-0">2007-2023<br>Разработка продуктов (Go, Swift)</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card card-body text-center bg-light">
                                        <strong>Альфа-Банк, Ингосстрах, Dostavista</strong>
                                        <p class="text-muted mb-0">2018-2021<br>Scrum Master, Agile Coach</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card card-body text-center bg-light">
                                        <strong>ФОМ.РУ, ТВИЗ, АПОСТОЛ</strong>
                                        <p class="text-muted mb-0">2010-2015<br>Управление интернет-проектами</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-primary-alt">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="row">
                        <!-- Образование и сертификаты -->
                        <div class="col-md-6 mb-5">
                            <h3 class="h4 mb-4">Образование и развитие</h3>

                            <div class="card card-body shadow-1 mb-3 bg-white">
                                <h5 class="text-primary">Пензенский государственный университет</h5>
                                <p class="mb-0">Вычислительные машины, комплексы, системы и сети<br>2010 · Высшее</p>
                            </div>

                            <h5 class="mt-4 mb-3">Ключевые сертификаты</h5>
                            <div class="card card-body shadow-1 mb-2 bg-white">
                                <strong>Advanced iOS Developer</strong>
                                <p class="text-muted mb-0">Practicum by Yandex (2026)</p>
                            </div>
                            <div class="card card-body shadow-1 mb-2 bg-white">
                                <strong>Advanced Go Developer</strong>
                                <p class="text-muted mb-0">Practicum by Yandex (2024)</p>
                            </div>
                            <div class="card card-body shadow-1 mb-2 bg-white">
                                <strong>SAFe Practitioner</strong>
                                <p class="text-muted mb-0">Scaled Agile Framework (2019)</p>
                            </div>
                            <div class="card card-body shadow-1 bg-white">
                                <strong>Management 3.0</strong>
                                <p class="text-muted mb-0">Agile Leadership (2021)</p>
                            </div>
                        </div>

                        <!-- Навыки -->
                        <div class="col-md-6 mb-5">
                            <h3 class="h4 mb-4">Ключевые навыки</h3>

                            <div class="card card-body shadow-1 mb-4 bg-white">
                                <h5 class="text-primary">Управленческие</h5>
                                <ul class="mb-0">
                                    <li>Стратегическое планирование и P&L</li>
                                    <li>Agile-трансформация (Scrum, SAFe, Kanban)</li>
                                    <li>Управление продуктом (Product Management)</li>
                                    <li>Построение команд и KPI-систем</li>
                                </ul>
                            </div>

                            <div class="card card-body shadow-1 bg-white">
                                <h5 class="text-primary">Технические</h5>
                                <ul class="mb-0">
                                    <li>Архитектура ПО и техническая стратегия</li>
                                    <li>Разработка (Go, Swift, JavaScript, PHP)</li>
                                    <li>DevOps и процессы разработки</li>
                                    <li>Системный анализ и UML</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <!-- О себе -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="h4 mb-4">О себе</h3>
                            <div class="card card-body shadow-1 bg-light">
                                <p class="lead">Стратегический IT-лидер с 17-летним опытом трансформации разработки в крупных компаниях. Специализируюсь на построении эффективных команд и внедрении процессов, которые напрямую влияют на бизнес-результаты.</p>
                                <p class="mb-0">Сочетаю глубокое техническое понимание с управленческой экспертизой для создания IT-стратегий, приносящих измеримую ценность.</p>
                                <div class="mt-3 p-3 bg-white rounded">
                                    <strong class="text-primary">Фокус на:</strong> Agile-трансформация, управление продуктом, масштабирование разработки, построение P&L-эффективных IT-направлений.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Рекомендации и портфолио -->
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <h3 class="h4 mb-4">Рекомендации</h3>
                            <div class="card card-body shadow-1 bg-light">
                                <div class="mb-3">
                                    <strong>Мелян Григорий</strong>
                                    <p class="text-muted mb-0">Исполнительный директор, Газпромбанк</p>
                                </div>
                                <div class="mb-3">
                                    <strong>Лавников Сергей</strong>
                                    <p class="text-muted mb-0">RTE, Ингосстрах</p>
                                </div>
                                <div>
                                    <strong>Кобыченко Дмитрий</strong>
                                    <p class="text-muted mb-0">Руководитель центра веб-разработок, Альфа-Банк</p>
                                </div>
                                <div class="mt-3 pt-3 border-top">
                                    <em class="text-muted">Контакты предоставляются по запросу</em>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <h3 class="h4 mb-4">Портфолио</h3>
                            <div class="card card-body shadow-1 bg-light">
                                <div class="mb-3">
                                    <strong>GitHub</strong>
                                    <p class="mb-0">github.com/eampleev23</p>
                                </div>
                                <div>
                                    <strong>Примеры продуктов</strong>
                                    <p class="mb-0">CRM-системы, мобильные приложения, веб-сервисы</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('pageScript')
    @parent
@endsection
