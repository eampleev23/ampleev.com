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
                    <span class="display-4 text-primary d-block" data-countup="" data-start="0" data-end="16"
                          data-duration="3" data-grouping="true">16</span>
                    <span class="h6">Количество команд, с которыми работал</span>
                </div>
                <div class="col-6 mb-3 col-lg-3 mb-lg-0 aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
                    <span class="display-4 text-primary d-block" data-countup="" data-start="-100" data-end="61"
                          data-duration="3" data-grouping="true">61</span>
                    <span class="h6">Количество успешно проведенных ретроспектив</span>
                </div>
                <div class="col-6 mb-3 col-lg-3 mb-lg-0 aos-init aos-animate" data-aos="fade-up" data-aos-delay="400">
                    <span class="display-4 text-primary d-block" data-countup="" data-start="-100" data-end="9"
                          data-duration="3" data-grouping="true" data-suffix=" из 10">9 из 10</span>
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
                                <span class="text-small text-muted">Декабрь 2020</span>
                                <h5 class="mb-0"><img src="assets/img/alfa_logo.svg"> &nbsp;&nbsp;&nbsp;Scrum Master в
                                    <a href="https://alfabank.ru">Альфа Банк</a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Декабрь 2020</span>
                                <h5 class="mb-0">Закончил работать в <a href="https://www.ingos.ru/">Ингосстрах</a></h5>
                            </div>
                        </li>

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
                                <h5 class="mb-0">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80"
                                         viewBox="0 0 50 24" fill="grey" class="svg-icon icon-logo-text">
                                        <path d="M13.4017 3.02165C13.0132 3.55136 12.75 4.40572 12.75 5.625V7.19766C12.75 7.70857 12.9239 8.20427 13.243 8.60322L14.774 10.5169C14.8477 10.5058 14.9232 10.5 15 10.5C15.8284 10.5 16.5 11.1716 16.5 12C16.5 12.8284 15.8284 13.5 15 13.5C14.1716 13.5 13.5 12.8284 13.5 12C13.5 11.8073 13.5363 11.623 13.6026 11.4538L12.0717 9.54026C11.5398 8.87534 11.25 8.04917 11.25 7.19766V5.625C11.25 4.21928 11.5493 3.01114 12.1921 2.1346C12.8567 1.22833 13.8369 0.75 15 0.75C16.8815 0.75 18.4917 1.90415 19.1642 3.54178C20.8756 4.04449 22.125 5.62568 22.125 7.5C22.125 7.87877 22.1172 8.28337 22.006 8.68595C23.192 9.31559 24 10.5628 24 12C24 13.4372 23.192 14.6845 22.0059 15.3141C22.1171 15.7166 22.1249 16.1211 22.1249 16.4999C22.1249 18.3742 20.8754 19.9554 19.1641 20.4581C18.4916 22.0957 16.8813 23.2499 14.9999 23.2499C14.51 23.2499 14.0369 23.1713 13.5935 23.0255L14.062 21.6006C14.3561 21.6972 14.6711 21.7499 14.9999 21.7499C16.3574 21.7499 17.5061 20.8476 17.8754 19.6085L18.0075 19.1652L18.463 19.0843C19.6918 18.866 20.6249 17.7911 20.6249 16.4999C20.6249 15.8478 20.5743 15.6094 20.393 15.389C20.1453 15.088 19.8113 14.9752 19.4487 15.0139C19.0688 15.0544 18.6734 15.2648 18.4038 15.6018L17.5224 16.7036C17.5886 16.8729 17.625 17.0572 17.625 17.25C17.625 18.0784 16.9534 18.75 16.125 18.75C15.2966 18.75 14.625 18.0784 14.625 17.25C14.625 16.4216 15.2966 15.75 16.125 15.75C16.2017 15.75 16.2771 15.7558 16.3508 15.7669L17.2325 14.6648C17.7451 14.024 18.5009 13.6065 19.2896 13.5224C19.9366 13.4533 20.6132 13.6109 21.1673 14.0554C21.9529 13.7042 22.5 12.9153 22.5 12C22.5 11.0847 21.9529 10.2957 21.1672 9.94458C20.6131 10.389 19.9366 10.5466 19.2896 10.4775C18.501 10.3933 17.7452 9.97582 17.2326 9.33505L16.351 8.23309C16.2773 8.24423 16.2018 8.25 16.125 8.25C15.2966 8.25 14.625 7.57843 14.625 6.75C14.625 5.92157 15.2966 5.25 16.125 5.25C16.9534 5.25 17.625 5.92157 17.625 6.75C17.625 6.94272 17.5887 7.12696 17.5224 7.29622L18.4039 8.39801C18.6735 8.73503 19.0689 8.94542 19.4488 8.98597C19.8113 9.02467 20.1453 8.91193 20.3931 8.61091C20.5744 8.39053 20.625 8.15209 20.625 7.5C20.625 6.20874 19.6919 5.13389 18.4631 4.91559L18.0077 4.83468L17.8755 4.39138C17.5062 3.15222 16.3575 2.25 15 2.25C14.2881 2.25 13.7683 2.52167 13.4017 3.02165Z"></path>
                                        <path d="M6.47756 16.7038C6.41135 16.873 6.375 17.0573 6.375 17.25C6.375 18.0784 7.04657 18.75 7.875 18.75C8.70343 18.75 9.375 18.0784 9.375 17.25C9.375 16.4216 8.70343 15.75 7.875 15.75C7.79818 15.75 7.72271 15.7558 7.649 15.7669L6.76743 14.6649C6.25482 14.0242 5.49903 13.6067 4.71043 13.5225C4.06341 13.4534 3.38688 13.611 2.83278 14.0554C2.0471 13.7043 1.5 12.9153 1.5 12C1.5 11.0847 2.04708 10.2958 2.83274 9.9446C3.38683 10.3891 4.06337 10.5467 4.71042 10.4776C5.49906 10.3935 6.25491 9.976 6.76755 9.33519L7.64921 8.23312C7.72285 8.24424 7.79825 8.25 7.875 8.25C8.70343 8.25 9.375 7.57843 9.375 6.75C9.375 5.92157 8.70343 5.25 7.875 5.25C7.04657 5.25 6.375 5.92157 6.375 6.75C6.375 6.9428 6.41137 7.1271 6.47763 7.29642L5.59624 8.39815C5.32662 8.73518 4.9312 8.94557 4.55127 8.98612C4.18875 9.0248 3.85469 8.91203 3.60698 8.61097C3.42567 8.39061 3.37512 8.15217 3.37512 7.50014C3.37512 6.20889 4.3082 5.13403 5.53701 4.91574L5.99246 4.83483L6.12459 4.39152C6.49391 3.15236 7.64263 2.25014 9.00012 2.25014C9.3289 2.25014 9.64389 2.30276 9.93801 2.39945L10.4065 0.974479C9.96306 0.828702 9.49002 0.750143 9.00012 0.750143C7.11866 0.750143 5.50843 1.90429 4.83591 3.54192C3.12457 4.04463 1.87512 5.62582 1.87512 7.50014C1.87512 7.87885 1.88291 8.28339 1.99407 8.68591C0.808044 9.31554 0 10.5628 0 12C0 13.4372 0.808009 14.6844 1.994 15.3141C1.88279 15.7166 1.875 16.1212 1.875 16.5C1.875 18.3743 3.12444 19.9555 4.83578 20.4582C5.50831 22.0958 7.11854 23.25 9 23.25C10.1631 23.25 11.1433 22.7717 11.8079 21.8654C12.4507 20.9889 12.75 19.7807 12.75 18.375V16.8023C12.75 15.9508 12.4602 15.1247 11.9283 14.4597L10.3974 12.5462C10.4637 12.377 10.5 12.1927 10.5 12C10.5 11.1716 9.82843 10.5 9 10.5C8.17157 10.5 7.5 11.1716 7.5 12C7.5 12.8284 8.17157 13.5 9 13.5C9.07682 13.5 9.15229 13.4942 9.226 13.4831L10.757 15.3968C11.0761 15.7957 11.25 16.2914 11.25 16.8023V18.375C11.25 19.5943 10.9868 20.4486 10.5983 20.9784C10.2317 21.4783 9.71191 21.75 9 21.75C7.64251 21.75 6.49379 20.8478 6.12446 19.6086L5.99234 19.1653L5.53689 19.0844C4.30808 18.8661 3.375 17.7913 3.375 16.5C3.375 15.8479 3.42555 15.6095 3.60692 15.3891C3.85466 15.0881 4.18871 14.9753 4.55121 15.014C4.93112 15.0546 5.32651 15.265 5.59612 15.602L6.47756 16.7038Z"></path>
                                    </svg>

                                    Окончил курс <a href="/assets/pdf/web_design_base.pdf">&#171;Основы
                                        Веб-дизайна&#187;</a>
                                    в <a href="https://geekbrains.ru/">Geekbrains</a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Март 2019</span>
                                <h5 class="mb-0">Окончил тренинг Golang (основы синтаксиса) в <a
                                            href="https://geekbrains.ru/">Geekbrains</a></h5>
                            </div>
                        </li>


                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Март 2019</span>
                                <h5 class="mb-0">Окончил тренинг <a href="/assets/pdf/safe_teams_compressed.pdf">SAFe
                                        for teams</a> в <a href="https://www.ingos.ru">Ингосстрах</a>
                                </h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Март 2019</span>
                                <h5 class="mb-0">Окончил тренинг <a href="/assets/pdf/safe_sm_compressed.pdf"> SAFe for
                                        Scrum Masters</a> в <a
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
                                <h5 class="mb-0">Окончил курс по Laravel Framework. Профессиональная
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
                                <h5 class="mb-0">Окончил курс <a href="/assets/pdf/react.pdf">&#171;ReactJS.
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
                                <h5 class="mb-0">Окончил курс JS. Уровень 2 в <a href="https://geekbrains.ru/">Geekbrains</a>
                                </h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Октябрь 2018</span>
                                <h5 class="mb-0">Окончил курс JS. Уровень 1 в <a href="https://geekbrains.ru/">Geekbrains</a>
                                </h5>
                            </div>
                        </li>


                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Апрель 2017</span>
                                <h5 class="mb-0">Окончил курс <a href="/assets/pdf/linux_level_1.pdf">&#171;Linux.
                                        Администрирование и конфигурирование&#187;</a> в <a
                                            href="https://geekbrains.ru/">Geekbrains</a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Апрель 2017</span>
                                <h5 class="mb-0">Окончил курс <a href="/assets/pdf/php_yii2.pdf">&#171;Yii2
                                        Framework. Профессиональная Backend-разработка&#187;</a> в <a
                                            href="https://geekbrains.ru/">Geekbrains</a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Апрель 2017</span>
                                <h5 class="mb-0">Окончил курс <a href="/assets/pdf/db_base_video.pdf">&#171;Основы баз
                                        данных. Язык SQL&#187;</a> в <a href="https://geekbrains.ru/">Geekbrains</a>
                                </h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Март 2017</span>
                                <h5 class="mb-0">Окончил курс <a href="/assets/pdf/php_level_2.pdf">&#171;PHP уровень 2&#187;</a>
                                    в <a href="https://geekbrains.ru/">Geekbrains</a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Январь 2017</span>
                                <h5 class="mb-0">Окончил &#171;HTML/CSS (продвинутый курс)&#187; в <a
                                            href="https://geekbrains.ru/">Geekbrains</a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Декабрь 2016</span>
                                <h5 class="mb-0">Окончил курс &#171;HTML/CSS&#187; в <a href="https://geekbrains.ru/">Geekbrains</a>
                                </h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Ноябрь 2016</span>
                                <h5 class="mb-0">Окончил курс <a href="/assets/pdf/git.pdf">&#171;Git. Быстрый старт.
                                        Инструмент командной разработки&#187;</a> в <a href="https://geekbrains.ru/">Geekbrains</a>
                                </h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Октябрь 2016</span>
                                <h5 class="mb-0">Окончил курс <a href="/assets/pdf/php_level_1.pdf">&#171;PHP уровень 1&#187;</a>
                                    в <a href="https://geekbrains.ru/">Geekbrains</a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Декабрь 2015</span>
                                <h5 class="mb-0">Окончил тренинг по Scrum в <a href="https://alfabank.ru">Альфа
                                        Банк</a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Ноябрь 2015</span>
                                <h5 class="mb-0"><img src="assets/img/alfa_logo.svg"> &nbsp;&nbsp;&nbsp;Web Site Manager
                                    в <a href="https://alfabank.ru">Альфа Банк</a></h5>
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
                                <h5 class="mb-0">Окончил 2-х недельный очный курс с Американцем по повышению уровня
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
                                <h5 class="mb-0">Окончил Факультет вычислительной техники <a
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