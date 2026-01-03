@extends('layouts.app')

@section('title', 'О компании')
@section('description', 'Информация о компании и команде')
@section('page_url', route('static_pages.about_company'))

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
                            <li class="breadcrumb-item"><a href="{{ route('static_pages.home') }}">Главная</a></li>
                            <li class="breadcrumb-item"><a href="#">Страницы</a></li>
                            <li class="breadcrumb-item active" aria-current="page">О компании</li>
                        </ol>
                    </nav>
                    <h1 data-aos="fade-up" data-aos-delay="200">О нас</h1>
                    <p class="lead" data-aos="fade-up" data-aos-delay="300">
                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa.
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
                    <h2 class="mb-4" data-aos="fade-up">В цифрах</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-3 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-center">
                        <div class="h1 mb-2" data-countup="" data-start="0" data-end="50000" data-duration="2" data-easing="true">0</div>
                        <div class="text-small">Активных пользователей в месяц</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-center">
                        <div class="h1 mb-2" data-countup="" data-start="0" data-end="120" data-duration="2" data-easing="true">0</div>
                        <div class="text-small">Членов команды</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-center">
                        <div class="h1 mb-2" data-countup="" data-start="0" data-end="15000" data-duration="2" data-easing="true">0</div>
                        <div class="text-small">Опубликованных проектов</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="400">
                    <div class="text-center">
                        <div class="h1 mb-2" data-countup="" data-start="0" data-end="99" data-duration="2" data-easing="true">0</div>
                        <div class="text-small">% Время работы сервера</div>
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
                                <span class="badge badge-primary">Наша миссия</span>
                                <h2 class="mt-2">Изменить игру через дизайн</h2>
                            </div>
                            <p class="lead">
                                At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati.
                            </p>
                            <p>
                                Cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.
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
                    <h2 class="mb-4" data-aos="fade-up">Команда лидеров</h2>
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
                        <span class="text-small text-muted">Дизайнер</span>
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
                            <h2 data-aos="fade-up">Наша история</h2>
                        </div>
                    </div>
                    <ol class="process-vertical">
                        <li data-aos="fade-left" data-aos-delay="100">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Октябрь 2016</span>
                                <h5>Получено финансирование Series-A</h5>
                            </div>
                        </li>
                        <li data-aos="fade-left" data-aos-delay="200">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Апрель 2017</span>
                                <h5>Новый CTO: Имя Фамилия</h5>
                            </div>
                        </li>
                        <li data-aos="fade-left" data-aos-delay="300">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Октябрь 2017</span>
                                <h5>Выход версии 1.0</h5>
                            </div>
                        </li>
                        <li data-aos="fade-left" data-aos-delay="400">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Февраль 2018</span>
                                <h5>Упоминание в Wired</h5>
                            </div>
                        </li>
                        <li data-aos="fade-left" data-aos-delay="500">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Сентябрь 2018</span>
                                <h5>Выход версии 2.0</h5>
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

