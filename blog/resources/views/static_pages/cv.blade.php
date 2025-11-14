@extends('layouts.app')

@section('title', 'Обо мне')
@section('description', 'Амплеев Евгений Михайлович')
@section('page_url', route('static_pages.cv'))

@section('custom_css')
    @parent
@endsection

@section('sidebar')
    @parent
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css" media="all"/>
@endsection

@section('content')
    @include('layouts.navbar')
    <section class="bg-dark text-light header-inner p-0 jarallax o-hidden" data-overlay="" data-jarallax=""
             data-speed="0.2" style="padding-top: 69.2656px !important;">

        <div class="container py-0 layer-2">
            <div class="row my-3">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('blog.blog')}}">Блог</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Обо мне</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row my-4 my-md-6 aos-init aos-animate" data-aos="fade-up">
                <div class="col-lg-9 col-xl-8">
                    <header>
                    <h1 class="display-4">IT-менеджер</h1>
                    </header>
                    <p class="lead mb-0">Амплеев Евгений Михайлович</p>
                </div>
            </div>
        </div>
        <div class="decoration-wrapper">
            <div class="decoration bottom right d-none d-md-block" data-jarallax-element="100 100"
                 style="z-index: 0; transform: translate3d(-5.65621px, -5.65621px, 0px);">
                <img class="bg-primary-2" src="" alt="deco-blob-1 decoration" data-inject-svg="">
                <div id="jarallax-container-1"
                     style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; overflow: hidden; pointer-events: none; z-index: -100;">
                    <div style="position: fixed;"></div>
                </div>
            </div>
        </div>
        <div class="divider flip-x">
            <img src="" alt="graphical divider" data-inject-svg="">
        </div>
        <div id="jarallax-container-0"
             style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; overflow: hidden; pointer-events: none; z-index: -100;">
            <img src="assets/img/inner-1.jpg" alt="Image" class="jarallax-img opacity-30"
                 style="object-fit: cover; object-position: 50% 50%; max-width: none; position: fixed; top: 0px; left: 0px; width: 975px; height: 745.834px; overflow: hidden; pointer-events: none; margin-top: 37.5828px; transform: translate3d(0px, -37.5828px, 0px);">
        </div>
    </section>
    <main>
        <section>
            <h2>Контактная информация</h2>
            <ul>
                <li>Мобильный телефон: +7 995 783-22-77</li>
                <li>Электронная почта: e@mpleev.com (предпочитаемый способ связи)</li>
            </ul>
        </section>

        <section>
            <h2>Предпочтения по работе</h2>
            <ul>
                <li>Тип занятости: Постоянная работа</li>
                <li>Формат работы: На месте работодателя, Удалённо, Гибрид</li>
                <li>Желательное время в пути до работы: Не дольше 1 часа</li>
                <li>Командировки: Могу</li>
            </ul>
        </section>

        <section>
            <h2>Опыт работы: 17 лет 8 месяцев</h2>

            <article>
                <h3>Главный эксперт по методологии разработки</h3>
                <p>Ноябрь 2024 — Сентябрь 2025 (11 месяцев)</p>
                <p>Построение модели процессов разработки и поддержки ПО для аэропорта (импортозамещение) AS IS. Выявление проблем и разработка методологии, соответствующей запросам заинтересованных сторон.</p>
            </article>

            <article>
                <h3>Исполнительный директор</h3>
                <p>Газпромбанк, ОАО</p>
                <p>Февраль 2024 — Сентябрь 2024 (8 месяцев)</p>
                <ul>
                    <li>Разработка, внедрение, мониторинг применения и развитие методики по определению команд службы управления рисками к премированию</li>
                    <li>Разработка, внедрение, мониторинг применения и развитие методики по определению бизнес-эффектов от реализуемых квартальных целей команд службы управления рисками</li>
                    <li>Разработка, внедрение, мониторинг применения и развитие единой методики по определению сложности реализуемых квартальных целей команд службы управления рисками</li>
                </ul>
            </article>

            <article>
                <h3>Agile Coach</h3>
                <p>Банк ВТБ (ПАО)</p>
                <p>Февраль 2021 — Сентябрь 2023 (2 года и 8 месяцев)</p>
                <p>Работа со стримами розничного блока бизнеса (зарплатные сервисы, партнерские сервисы, забота о клиентах, виртуальные ассистенты), общебанковские активности (ведение школы скрам мастеров, разработка целеполагания для коучей, проведение обучений, митапов)</p>
            </article>

            <article>
                <h3>Главный менеджер продукта (сайт и CRM)</h3>
                <p>markethot.ru</p>
                <p>Февраль 2015 — Март 2023 (8 лет и 2 месяца)</p>
                <p>Руководство командой (3 скрам-команды, у каждой product owner и свои разработчики фулстек фултайм, тестировщик(и), дизайнеры)</p>
                <ul>
                    <li>Организация и контроль брейнстормов</li>
                    <li>Кадровый менеджмент</li>
                    <li>Финансовый менеджмент</li>
                    <li>Продуктовый менеджмент</li>
                    <li>Операционный менеджмент</li>
                    <li>Проектный менеджмент</li>
                </ul>
                <p><strong>Достижения:</strong></p>
                <ul>
                    <li>Переход от работы команды с Waterfall на Scrum, организация скрам-команд</li>
                    <li>Существенный рост доходов компании благодаря концентрации усилий на бизнес-важных направлениях</li>
                    <li>Реализация CRM "aCRM" - CRM (Web-приложение)</li>
                    <li>Разработка мобильного приложения android, web для склада</li>
                </ul>
            </article>

            <article>
                <h3>Индивидуальный предприниматель</h3>
                <p>ИП Амплеев</p>
                <p>Сентябрь 2007 — Март 2023 (15 лет и 7 месяцев)</p>
                <p>Разработка собственных продуктов и заказная разработка (фокус на стек go, swift)</p>
                <ul>
                    <li>Запуск MVP собственными силами и найм и управление командой в случае успеха MVP</li>
                    <li>Найм и управление командой в случае заказной разработки</li>
                </ul>
            </article>

            <article>
                <h3>Scrum Master продукта Alfa Business Mobile</h3>
                <p>Альфа-Банк (Россия)</p>
                <p>Ноябрь 2020 — Февраль 2021 (4 месяца)</p>
                <p>Классические функции: диагностика команд, помощь командам в развитии agile-культуры, обучение agile-практикам</p>
            </article>

            <article>
                <h3>Scrum Master</h3>
                <p>Ингосстрах</p>
                <p>Февраль 2019 — Февраль 2021 (2 года и 1 месяц)</p>
                <p>Функционал Scrum Master-а(RTE) поезда online 3 команды "Байкал"(11 человек вместе с PO и SM: 2 аналитика, 5 фулстек разработчиков, 3 тестировщика), 2 подрядчика</p>
                <p>Framework SAFe</p>
            </article>

            <article>
                <h3>Senior Project Manager (Back-End Team) / Scrum Master</h3>
                <p>Dostavista Group</p>
                <p>Сентябрь 2018 — Декабрь 2018 (4 месяца)</p>
                <p>Сбор и формализация требований от стейкхолдеров и продакт менеджеров, сопровождение задач от идеи до реализации (на англ языке для всех 10 стран)</p>
            </article>

            <article>
                <h3>Менеджер направления</h3>
                <p>Альфа-Банк (Россия)</p>
                <p>Ноябрь 2015 — Февраль 2018 (2 года и 4 месяца)</p>
                <p>PM по БРБ(блок розничного бизнеса) сайта alfabank.ru</p>
                <ul>
                    <li>Регламент прозрачного и понятного топ-менеджменту процесса разработки сайта и его внедрение (agile, scrum)</li>
                    <li>Сотрудничество с FIFA в контексте web</li>
                    <li>Взаимодействие с Google по запуску Android Pay в контексте web</li>
                </ul>
            </article>

            <article>
                <h3>Менеджер интернет-проектов</h3>
                <p>АПОСТОЛ</p>
                <p>Август 2013 — Февраль 2015 (1 год и 7 месяцев)</p>
                <p>Менеджмент интернет-проектов (tinakandelaki.ru, умная школа)</p>
            </article>

            <article>
                <h3>Технический менеджер проектов</h3>
                <p>ООО "ТВИЗ"</p>
                <p>Август 2012 — Ноябрь 2012 (4 месяца)</p>
                <p>Управление разработкой iOS и Android клиентов приложения tviz.tv</p>
            </article>

            <article>
                <h3>Senior Project Manager / Старший менеджер проектов</h3>
                <p>ООО "ФОМ.РУ"</p>
                <p>Октябрь 2010 — Сентябрь 2012 (2 года)</p>
                <p>Управление ИТ проектами (ответственность за все фазы проекта - инициации, реализации, контроля исполнения, завершения)</p>
            </article>
        </section>

        <section>
            <h2>Навыки</h2>
            <h3>Продвинутый уровень:</h3>
            <ul>
                <li>Agile Project Management</li>
                <li>Scrum</li>
                <li>ООП</li>
                <li>Руководство коллективом</li>
                <li>Стратегический менеджмент</li>
                <li>MVC</li>
                <li>Информационные технологии</li>
                <li>Оптимизация бизнес-процессов</li>
                <li>Управление интернет-проектами</li>
                <li>Обучение и развитие</li>
                <li>Project management</li>
                <li>Деловое общение</li>
                <li>Организаторские навыки</li>
                <li>Разработка ПО</li>
            </ul>

            <h3>Средний уровень:</h3>
            <ul>
                <li>UML</li>
                <li>Product Management</li>
                <li>Git</li>
                <li>MySQL</li>
                <li>JavaScript</li>
                <li>PHP</li>
                <li>Atlassian Jira</li>
                <li>Английский язык</li>
                <li>Linux</li>
                <li>Sass</li>
                <li>JSON API</li>
                <li>Laravel</li>
                <li>Golang</li>
                <li>Swift</li>
                <li>Start-up project</li>
            </ul>

            <h3>Базовый уровень:</h3>
            <ul>
                <li>Bootstrap</li>
            </ul>
        </section>

        <section>
            <h2>Образование</h2>
            <p><strong>Пензенский государственный университет, Пенза</strong></p>
            <p>Вычислительные машины, комплексы, системы и сети</p>
            <p>2010 · Высшее</p>
        </section>

        <section>
            <h2>Повышение квалификации, курсы</h2>
            <ul>
                <li>iOS-разработчик расширенный - Practicum by Yandex (2026)</li>
                <li>Advanced Go Developer Professional Training Course - Practicum by Yandex (2024)</li>
                <li>Management 3.0 - management30.com (2021)</li>
                <li>Laravel Framework. Профессиональная Backend-разработка - rdavydov (2019)</li>
                <li>SAFe for teams - ionovpartners.ru (2019)</li>
                <li>SAFe for Scrum Masters - ionovpartners.ru (2019)</li>
                <li>Golang - Geekbrains (2019)</li>
                <li>ReactJS. Профессиональная frontend-разработка - Geekbrains (2018)</li>
                <li>JS. Уровень 1, Уровень 2 - Geekbrains (2018)</li>
                <li>Git. Быстрый старт. Инструмент командной разработки - Geekbrains (2017)</li>
                <li>Linux. Администрирование и конфигурирование - Geekbrains (2017)</li>
                <li>Yii2 Framework. Профессиональная Backend-разработка - Geekbrains (2017)</li>
                <li>PHP уровень 1, уровень 2 - Geekbrains (2017)</li>
                <li>Основы баз данных. Язык SQL - Geekbrains (2017)</li>
                <li>HTML/CSS, HTML/CSS (продвинутый курс) - Geekbrains (2017)</li>
            </ul>
        </section>

        <section>
            <h2>Сертификаты</h2>
            <ul>
                <li>Advanced Go Developer Professional Training Course (2024)</li>
                <li>Advanced Management 3.0 (2021)</li>
                <li>ReactJS. Профессиональная frontend-разработка (2018)</li>
                <li>Git. Быстрый старт. Инструмент командной разработки (2017)</li>
                <li>Linux. Администрирование и конфигурирование (2017)</li>
                <li>Yii2 Framework. Профессиональная Backend-разработка (2017)</li>
                <li>PHP уровень 1 (2017)</li>
                <li>PHP уровень 2 (2017)</li>
                <li>Основы баз данных. Язык SQL (2017)</li>
            </ul>
        </section>

        <section>
            <h2>Рекомендации</h2>
            <ul>
                <li>Мелян Григорий - Исполнительный директор, Газпромбанк, ОАО</li>
                <li>Лавников Сергей - RTE, Ингосстрах</li>
                <li>Ярослав Агарков - Старший менеджер проектов, Dostavista.ru</li>
                <li>Максим Королев - Исполнительный директор, ЦСК "Апоcтол"</li>
                <li>Самородкин Дмитрий - CTO, tviz.tv</li>
                <li>Кобыченко Дмитрий - Руководитель центра веб-разработок, Альфа Банк</li>
                <li>Брылев Кирилл Андреевич - Директор по развитию, Группа ФОМ</li>
            </ul>
        </section>

        <section>
            <h2>Портфолио</h2>
            <ul>
                <li>Сайт Тины Канделаки</li>
                <li>Пример интерфейса для альфы</li>
                <li>crowdspace.com</li>
                <li>ACRM</li>
                <li>Android приложение CRM</li>
                <li>https://github.com/eampleev23</li>
            </ul>
        </section>

        <section>
            <h2>О себе</h2>
            <p>На последнем рабочем месте получил большой опыт в описании методологии, соответствующей существующим ролям в компании и стандартизирующей процессы.</p>
            <p>Большой опыт в организации команд разработки по гибким методологиям (переход к гибким методологиям на базе принципов Agile: Scrum, Kanban), проектировании сложных технических решений (соц опросы для ФОМ онлайн, краудсорсинговая платформа, вопросы-ответы с игровой механикой, CMS банка, CRM для интернет-магазинов).</p>
        </section>
    </main>
@endsection

@section('pageScript')
    @parent
@endsection
