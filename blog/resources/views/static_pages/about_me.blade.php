@extends('layouts.app')

@section('title', 'Обо мне')
@section('description', 'На данной странице вы получите исчерпывающую информацию обо мне')
@section('page_url', route('static_pages.about_me'))

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
                                <a href="{{route('blog.home')}}">Блог</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Обо мне</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row my-4 my-md-6 aos-init aos-animate" data-aos="fade-up">
                <div class="col-lg-9 col-xl-8">
                    <h1 class="display-4">Обо мне</h1>
                    <p class="lead mb-0">На данной странице вы получите исчерпывающую информацию обо мне.</p>
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

    <section>
        <div class="container">
            <div class="row mb-4">
                <div class="col">
                    <h2>В цифрах</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-6 mb-3 col-lg-3 mb-lg-0 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                    <span class="display-4 text-primary d-block" data-countup="" data-start="0" data-end="14"
                          data-duration="3" data-grouping="true" data-suffix=" лет">14</span>
                    <span class="h6">Общий опыт в IT</span>
                </div>
                <div class="col-6 mb-3 col-lg-3 mb-lg-0 aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                    <span class="display-4 text-primary d-block" data-countup="" data-start="0" data-end="12"
                          data-duration="3" data-grouping="true">12</span>
                    <span class="h6">Количество команд, с которыми работал</span>
                </div>
                <div class="col-6 mb-3 col-lg-3 mb-lg-0 aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
                    <span class="display-4 text-primary d-block" data-countup="" data-start="-100" data-end="57"
                          data-duration="3" data-grouping="true">57</span>
                    <span class="h6">Количество успешно проведенных ретроспектив</span>
                </div>
                <div class="col-6 mb-3 col-lg-3 mb-lg-0 aos-init aos-animate" data-aos="fade-up" data-aos-delay="400">
                    <span class="display-4 text-primary d-block" data-countup="" data-start="-100" data-end="8"
                          data-duration="3" data-grouping="true" data-suffix=" из 10">8 из 10</span>
                    <span class="h6">Средняя обратная связь по фасилитации</span>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container aos-init aos-animate" data-aos="fade-up">
            <div class="row align-items-center justify-content-around">
                <div class="col-md-5 col-xl-6 mb-4 mb-md-0">
                    <img src="assets/img/inner-2.jpg" alt="Image" class="rounded shadow-3d">
                </div>
                <div class="col-md-7 col-xl-6">
                    <div class="row justify-content-center">
                        <div class="col-xl-8 col-lg-10">
                            <span class="badge badge-primary">Коротко</span>
                            <div class="my-3">
                                <span class="h1">Обо мне</span>
                            </div>
                            <p class="lead">"Кем я вижу себя через 5 лет?" - тем же, кем вижу сейчас: человеком,
                                делающим максимум для профессионального развития и применяющим полученные навыки для
                                улучшения мира.</p>

                            <p class="lead mb-0">"Зачем столько курсов по разработке?" - всегда хотел иметь возможность
                                при необходимости самостоятельно запустить MVP и быстро проверить какую-либо
                                гипотезу. Также считаю, что в современном мире не уметь писать код - это не очень (но
                                никому не навязываю). Также считаю, что умение разрабатывать (особенно Full Stack) очень
                                полезно в профессии Скрам Мастера, работающего в командах клиент-серверной
                                разработки.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-primary-alt o-hidden">
        <div class="container">
            <div class="row mb-4">
                <div class="col">
                    <h2>Карьера</h2>
                </div>
            </div>
            <div class="row o-hidden o-lg-visible">
                <div class="col d-flex flex-column align-items-center">
                    <ol class="process-vertical">
                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Январь 2020</span>
                                <h5 class="mb-0">Запуск <a href="{{route('blog.home')}}">Ampleev.com</a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Январь 2020</span>
                                <h5 class="mb-0">Закончил курс <a href="/assets/pdf/web_design_base.pdf">&#171;Основы
                                        Веб-дизайна&#187;</a>
                                    в <a href="https://geekbrains.ru/">Geekbrains</a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Март 2019</span>
                                <h5 class="mb-0">Закончил тренинг Golang (основы синтаксиса) в <a
                                            href="https://geekbrains.ru/">Geekbrains</a></h5>
                            </div>
                        </li>



                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Март 2019</span>
                                <h5 class="mb-0">Закончил тренинг <a href="/assets/pdf/safe_teams_compressed.pdf">SAFe for teams</a> в <a href="https://www.ingos.ru">Ингосстрах</a>
                                </h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Март 2019</span>
                                <h5 class="mb-0">Закончил тренинг <a href="/assets/pdf/safe_sm_compressed.pdf"> SAFe for Scrum Masters</a> в <a
                                            href="https://www.ingos.ru">Ингосстрах</a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Февраль 2019</span>
                                <h5 class="mb-0">SAFe Scrum Master (Full Stack Team) в <a href="https://www.ingos.ru">Ингосстрах</a>
                                </h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Январь 2019</span>
                                <h5 class="mb-0">Закончил курс по Laravel Framework. Профессиональная
                                    Backend-разработка.</h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Декабрь 2018</span>
                                <h5 class="mb-0">Закончил работать в <a href="https://dostavista.global">Dostavista
                                        Group</a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Сентябрь 2018</span>
                                <h5 class="mb-0">Senior Project Manager (Back-End Team) / Scrum Master в <a
                                            href="https://dostavista.global">Dostavista
                                        Group</a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Март 2018</span>
                                <h5 class="mb-0">Закончил курс <a href="/assets/pdf/react.pdf">&#171;ReactJS.
                                        Профессиональная frontend-разработка&#187;</a> в <a
                                            href="https://geekbrains.ru/">Geekbrains</a></h5>
                            </div>
                        </li>


                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Февраль 2018</span>
                                <h5 class="mb-0">Закончил работать в <a href="https://alfabank.ru">Альфа Банк</a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Ноябрь 2018</span>
                                <h5 class="mb-0">Закончил курс JS. Уровень 2 в <a href="https://geekbrains.ru/">Geekbrains</a>
                                </h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Октябрь 2018</span>
                                <h5 class="mb-0">Закончил курс JS. Уровень 1 в <a href="https://geekbrains.ru/">Geekbrains</a>
                                </h5>
                            </div>
                        </li>


                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Апрель 2017</span>
                                <h5 class="mb-0">Закончил курс <a href="/assets/pdf/linux_level_1.pdf">&#171;Linux.
                                        Администрирование и конфигурирование&#187;</a> в <a
                                            href="https://geekbrains.ru/">Geekbrains</a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Апрель 2017</span>
                                <h5 class="mb-0">Закончил курс <a href="/assets/pdf/php_yii2.pdf">&#171;Yii2
                                        Framework. Профессиональная Backend-разработка&#187;</a> в <a
                                            href="https://geekbrains.ru/">Geekbrains</a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Апрель 2017</span>
                                <h5 class="mb-0">Закончил курс <a href="/assets/pdf/db_base_video.pdf">&#171;Основы баз
                                        данных. Язык SQL&#187;</a> в <a href="https://geekbrains.ru/">Geekbrains</a>
                                </h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Март 2017</span>
                                <h5 class="mb-0">Закончил курс <a href="/assets/pdf/php_level_2.pdf">&#171;PHP уровень 2&#187;</a>
                                    в <a href="https://geekbrains.ru/">Geekbrains</a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Январь 2017</span>
                                <h5 class="mb-0">Закончил &#171;HTML/CSS (продвинутый курс)&#187; в <a
                                            href="https://geekbrains.ru/">Geekbrains</a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Декабрь 2016</span>
                                <h5 class="mb-0">Закончил курс &#171;HTML/CSS&#187; в <a href="https://geekbrains.ru/">Geekbrains</a>
                                </h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Ноябрь 2016</span>
                                <h5 class="mb-0">Закончил курс <a href="/assets/pdf/git.pdf">&#171;Git. Быстрый старт.
                                        Инструмент командной разработки&#187;</a> в <a href="https://geekbrains.ru/">Geekbrains</a>
                                </h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Октябрь 2016</span>
                                <h5 class="mb-0">Закончил курс <a href="/assets/pdf/php_level_1.pdf">&#171;PHP уровень 1&#187;</a>
                                    в <a href="https://geekbrains.ru/">Geekbrains</a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Декабрь 2015</span>
                                <h5 class="mb-0">Закончил тренинг по Scrum в <a href="https://alfabank.ru">Альфа
                                        Банк</a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Ноябрь 2015</span>
                                <h5 class="mb-0">Web Site Manager в <a href="https://alfabank.ru">Альфа Банк</a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Ноябрь 2015</span>
                                <h5 class="mb-0">Закончил работать в <a href="https://fom.ru">ФОМ (Фонд Общественное
                                        Мнение)</a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Июнь 2015</span>
                                <h5 class="mb-0">Закончил 2-х недельный очный курс с Американцем по повышению уровня
                                    знаний Американского Английского языка (до Intermediate) во <a
                                            href="http://framestar.ru/">Frame Star</a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Октябрь 2010</span>
                                <h5 class="mb-0">Senior Project Manager в <a href="https://fom.ru">ФОМ (Фонд
                                        Общественное Мнение)</a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Июнь 2010</span>
                                <h5 class="mb-0">Закончил Факультет вычислительной техники <a
                                            href="https://www.pnzgu.ru"> Пензенского государственного
                                        университета</a> по специальности &#171;Вычислительные машины, комплексы,
                                    системы и
                                    сети&#187;</h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Сентябрь 2007</span>
                                <h5 class="mb-0">Индивидуальный предприниматель (web-проекты)</h5>
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
@endsection