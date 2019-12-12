<!-- Stored in resources/views/child.blade.php -->

@extends('layouts.app')

@section('title', 'Главная страница')

@section('custom_css')
    @parent
@endsection

@section('sidebar')
    @parent
    {{--    <p>This is appended to the master sidebar.</p>--}}
@endsection

@section('content')

    <div class="navbar-container ">
        <nav class="navbar navbar-expand-lg navbar-dark" data-overlay>
            <div class="container">
                <a class="navbar-brand fade-page" href="/">
                    <span>Амплеев Евгений</span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <img class="icon navbar-toggler-open" src="assets/img/icons/interface/menu.svg"
                         alt="menu interface icon" data-inject-svg/>
                    <img class="icon navbar-toggler-close" src="assets/img/icons/interface/cross.svg"
                         alt="cross interface icon" data-inject-svg/>
                </button>
                <div class="collapse navbar-collapse justify-content-end">
                    <div class="py-2 py-lg-0">
                        <ul class="navbar-nav">
                            {{--                        <li class="nav-item dropdown">--}}
                            {{--                            <a href="#" class="nav-link"--}}
                            {{--                               aria-expanded="false" aria-haspopup="true">Главная</a>--}}
                            {{--                        </li>--}}
                            {{--                        <li class="nav-item dropdown">--}}
                            {{--                            <a href="#" class="nav-link"--}}
                            {{--                               aria-expanded="false">Блог</a>--}}

                            {{--                        </li>--}}

                        </ul>
                    </div>
                    <a href="#" class="btn btn-primary ml-lg-3">Авторизоваться</a>

                </div>
            </div>
        </nav>
    </div>

    <section class="has-divider text-light jarallax bg-dark" data-jarallax data-speed="0.5" data-overlay>
        <img src="assets/img/article-9.jpg" alt="" class="jarallax-img opacity-50">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-8">
                    <h1 class="display-4">Блог</h1>
                    <p class="lead mb-0">Планирую писать здесь обо всем, что меня волнует. В основном, это будет, как
                        мне
                        кажется, об Agile, но это не точно :)</p>
                </div>
            </div>
        </div>
        <div class="divider">
            <img src="assets/img/dividers/divider-2.svg" alt="graphical divider" data-inject-svg/>
        </div>
    </section>
    <section data-overlay>
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-8 col-lg-9">
                    <div class="pr-lg-4">
                        <a href="#" class="card card-body justify-content-between bg-primary text-light">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="text-small d-flex">
                                    <div class="mr-2">
                                        Ссылки
                                    </div>
                                    <span class="opacity-70">19 Декабря</span>
                                </div>
                                <span class="badge bg-primary-alt text-primary">
                    <img class="icon icon-sm bg-primary" src="assets/img/icons/interface/heart.svg"
                         alt="heart interface icon" data-inject-svg/>27
                  </span>
                            </div>
                            <div>
                                <h2>Полезное приложение, которое позволяет эффективно планировать собственное время и не
                                    только.</h2>
                                <span class="text-small opacity-70">https://www.notion.so</span>
                            </div>
                        </a>
                    </div>
                    <div class="pr-lg-4">
                        <div class="card card-article-wide flex-md-row no-gutters">
                            <a href="{{route('blog.article_test')}}" class="col-md-4">
                                <img src="assets/img/article-1_my.jpg" alt="Image" class="card-img-top">
                            </a>
                            <div class="card-body d-flex flex-column col-auto p-4">
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="text-small d-flex">
                                        <div class="mr-2">
                                            <a href="#">SAFe</a>
                                        </div>
                                        <span class="text-muted">29 Ноября</span>
                                    </div>
                                    <span class="badge bg-primary-alt text-primary">
                      <img class="icon icon-sm bg-primary" src="assets/img/icons/interface/heart.svg"
                           alt="heart interface icon" data-inject-svg/>12
                    </span>
                                </div>
                                <a href="{{route('blog.article_test')}}" class="flex-grow-1">
                                    <h3>Диаграммы сгорания в контексте SAFe</h3>
                                </a>
                                <div class="d-flex align-items-center mt-3">
                                    <img src="assets/img/avatars/female-3_my.jpg" alt="Image" class="avatar avatar-sm">
                                    <div class="ml-1">
                                        <span class="text-small">Амплеев Евгений</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pr-lg-4">
                        <div class="card card-article-wide flex-md-row no-gutters">
                            <a href="#" class="col-md-4">
                                <img src="assets/img/article-2_my.jpg" alt="Image" class="card-img-top">
                            </a>
                            <div class="card-body d-flex flex-column col-auto p-4">
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="text-small d-flex">
                                        <div class="mr-2">
                                            <a href="#">Scrum</a>
                                        </div>
                                        <span class="text-muted">27 Ноября</span>
                                    </div>
                                    <span class="badge bg-primary-alt text-primary">
                      <img class="icon icon-sm bg-primary" src="assets/img/icons/interface/heart.svg"
                           alt="heart interface icon" data-inject-svg/>23
                    </span>
                                </div>
                                <a href="#" class="flex-grow-1">
                                    <h3>Cumulative Flow в спринте</h3>
                                </a>
                                <div class="d-flex align-items-center mt-3">
                                    <img src="assets/img/avatars/female-3_my.jpg" alt="Image" class="avatar avatar-sm">
                                    <div class="ml-1">
                                        <span class="text-small">Амплеев Евгений</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pr-lg-4">
                        <div class="card card-article-wide flex-md-row no-gutters">
                            <a href="#" class="col-md-4">
                                <img src="assets/img/article-3.jpg" alt="Image" class="card-img-top">
                            </a>
                            <div class="card-body d-flex flex-column col-auto p-4">
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="text-small d-flex">
                                        <div class="mr-2">
                                            <a href="#">Agile</a>
                                        </div>
                                        <span class="text-muted">23 Ноября</span>
                                    </div>
                                    <span class="badge bg-primary-alt text-primary">
                      <img class="icon icon-sm bg-primary" src="assets/img/icons/interface/heart.svg"
                           alt="heart interface icon" data-inject-svg/>82
                    </span>
                                </div>
                                <a href="#" class="flex-grow-1">
                                    <h3>Персональный рейтинг в Agile</h3>
                                </a>
                                <div class="d-flex align-items-center mt-3">
                                    <img src="assets/img/avatars/female-3_my.jpg" alt="Image" class="avatar avatar-sm">
                                    <div class="ml-1">
                                        {{--                                    <span class="text-small text-muted">By</span>--}}
                                        <span class="text-small">Амплеев Евгений</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pr-lg-4">
                        <div class="card card-body justify-content-between bg-primary-2 text-light">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="text-small d-flex">
                                    <div class="mr-2">
                                        <a href="#">Цитата</a>
                                    </div>
                                    <span class="opacity-70">16 Ноября</span>
                                </div>
                                <span class="badge bg-primary text-light">
                    <img class="icon icon-sm bg-white" src="assets/img/icons/interface/heart.svg"
                         alt="heart interface icon" data-inject-svg/>93
                  </span>
                            </div>
                            <div>
                                {{--                            <h2>&ldquo;You either get acquired like Trello or live long enough to see yourself become--}}
                                {{--                                JIRA&rdquo;</h2>--}}
                                <h2>&#171;Вы либо достигаете предела посредством Trello, либо живете достаточно долго
                                    чтобы увидеть себя, использующим JIRA&#187;</h2>
                                <span class="text-small opacity-70">– Anne Souzakis</span>
                            </div>
                        </div>
                    </div>
                    <div class="pr-lg-4">
                        <div class="card card-article-wide flex-md-row no-gutters">
                            <a href="#" class="col-md-4">
                                <img src="assets/img/article-4_my.jpg" alt="Image" class="card-img-top">
                            </a>
                            <div class="card-body d-flex flex-column col-auto p-4">
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="text-small d-flex">
                                        <div class="mr-2">
                                            <a href="#">Coding</a>
                                        </div>
                                        <span class="text-muted">16 Ноября</span>
                                    </div>
                                    <span class="badge bg-primary-alt text-primary">
                      <img class="icon icon-sm bg-primary" src="assets/img/icons/interface/heart.svg"
                           alt="heart interface icon" data-inject-svg/>93
                    </span>
                                </div>
                                <a href="#" class="flex-grow-1">
                                    <h3>Как я анализирую данные из *.CSV формата</h3>
                                </a>
                                <div class="d-flex align-items-center mt-3">
                                    <img src="assets/img/avatars/female-3_my.jpg" alt="Image" class="avatar avatar-sm">
                                    <div class="ml-1">
                                        {{--                                    <span class="text-small text-muted">By</span>--}}
                                        <span class="text-small">Амплеев Евгений</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-between align-items-center pr-lg-4">
                        <div class="col-auto">
                            <a href="#" class="btn btn-outline-white">Previous</a>
                        </div>
                        <div class="col-auto">
                            <nav>
                                <ul class="pagination mb-0">
                                    <li class="page-item active"><a class="page-link" href="#">1</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">2</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">3</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="col-auto">
                            <a href="#" class="btn btn-outline-white">Next</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3 d-none d-md-block">
                    <div class="mb-4">
                        <h5>Рассылки</h5>
                        <form action="/forms/mailchimp.php" data-form-email novalidate>
                            <div class="form-row">
                                <div class="col-12">
                                    <input type="email" class="form-control mb-2" placeholder="Email" name="email"
                                           required>
                                </div>
                                <div class="col-12">
                                    <div class="d-none alert alert-success" role="alert" data-success-message>
                                        Thanks, a member of our team will be in touch shortly.
                                    </div>
                                    <div class="d-none alert alert-danger" role="alert" data-error-message>
                                        Please fill all fields correctly.
                                    </div>
                                    <div data-recaptcha data-sitekey="INSERT_YOUR_RECAPTCHA_V2_SITEKEY_HERE"
                                         data-size="invisible" data-badge="bottomleft">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-loading btn-block"
                                            data-loading-text="Sending">
                                        <img class="icon" src="assets/img/icons/theme/code/loading.svg"
                                             alt="loading icon"
                                             data-inject-svg/>
                                        <span>Подписаться</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <small class="text-muted form-text">Мы никогда не раскроем ваши данные. Смотрите наши <a
                                    href="#">Условия
                                Конфиденциальности</a>
                        </small>

                    </div>
                    <div class="mb-4">
                        <h5>Популярное</h5>
                        <ul class="list-unstyled list-articles">
                            <li class="row row-tight">
                                <a href="{{route('blog.article_test')}}" class="col-3">
                                    <img src="assets/img/article-1_my.jpg" alt="Image" class="rounded">
                                </a>
                                <div class="col">
                                    <a href="{{route('blog.article_test')}}">
                                        <h6 class="mb-1">Диаграммы сгорания в контексте SAFe</h6>
                                    </a>
                                    <div class="d-flex text-small">
                                        <a href="#">Agile</a>
                                        <span class="text-muted ml-1">29 Ноября</span>
                                    </div>
                                </div>
                            </li>
                            <li class="row row-tight">
                                <a href="#" class="col-3">
                                    <img src="assets/img/article-2_my.jpg" alt="Image" class="rounded">
                                </a>
                                <div class="col">
                                    <a href="#">
                                        <h6 class="mb-1">Cumulative Flow в спринте</h6>
                                    </a>
                                    <div class="d-flex text-small">
                                        <a href="#">Scrum</a>
                                        <span class="text-muted ml-1">27 Ноября</span>
                                    </div>
                                </div>
                            </li>
                            <li class="row row-tight">
                                <a href="#" class="col-3">
                                    <img src="assets/img/article-3.jpg" alt="Image" class="rounded">
                                </a>
                                <div class="col">
                                    <a href="#">
                                        <h6 class="mb-1">Персональный рейтинг в Agile</h6>
                                    </a>
                                    <div class="d-flex text-small">
                                        <a href="#">Agile</a>
                                        <span class="text-muted ml-1">23 Ноября</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="sticky-top">
                        <a href="#"
                           class="bg-primary-3-alt rounded p-4 d-flex align-items-center justify-content-center min-vh-30">
                            <span class="text-small text-primary-3">Место для вашей рекламы</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="pt-0">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-xl-7 col-lg-8 col-md-10">
                    <h3 class="h2 mb-5">Получайте новости о новых публикациях прямо на свой email</h3>
                    <form action="/forms/mailchimp.php" data-form-email novalidate>
                        <div class="d-sm-flex flex-column flex-sm-row mb-3 justify-content-center">
                            <input type="email" name="email" class="mr-sm-1 mb-2 mb-sm-0 form-control form-control-lg"
                                   placeholder="Email Address" required>
                            <div data-recaptcha data-sitekey="INSERT_YOUR_RECAPTCHA_V2_SITEKEY_HERE"
                                 data-size="invisible"
                                 data-badge="bottomleft"></div>
                            <button type="submit" class="ml-sm-1 btn btn-lg btn-primary btn-loading"
                                    data-loading-text="Sending">
                                <img class="icon" src="assets/img/icons/theme/code/loading.svg" alt="loading icon"
                                     data-inject-svg/>
                                <span>Subscribe</span>
                            </button>
                        </div>
                        <div>
                            <div class="d-none alert alert-success" role="alert" data-success-message>
                                Thanks, a member of our team will be in touch shortly.
                            </div>
                            <div class="d-none alert alert-danger" role="alert" data-error-message>
                                Please fill all fields correctly.
                            </div>
                        </div>
                    </form>

                    <div class="text-small text-muted">
                        We’ll never share your details with third parties.
                        <br class="visible-md"/>View our <a href="#">Privacy Policy</a> for more info.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="pb-4 bg-primary-3 text-light" id="footer">
        <div class="container">
            <div class="row mb-5">
                <div class="col">
                    <div class="card card-body border-0 o-hidden mb-0 bg-primary text-light">
                        <div class="position-relative d-flex flex-column flex-md-row justify-content-between align-items-center">
                            <div class="h3 text-center mb-md-0">Start building beautiful websites</div>
                            <a href="#" class="btn btn-lg btn-white">
                                Purchase Now
                            </a>
                        </div>
                        <div class="decoration layer-0">
                            <img class="bg-primary-2" src="assets/img/decorations/deco-blob-1.svg"
                                 alt="deco-blob-1 decoration" data-inject-svg/>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row mb-5">
                <div class="col-6 col-lg-3 col-xl-2">
                    <h5>Navigate</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="#" class="nav-link">Demos</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Pages</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Portfolio</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Elements</a>
                        </li>
                    </ul>
                </div>
                <div class="col-6 col-lg">
                    <h5>Contact</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3 d-flex">
                            <img class="icon" src="assets/img/icons/theme/map/marker-1.svg" alt="marker-1 icon"
                                 data-inject-svg/>
                            <div class="ml-3">
                  <span>348 Greenpoint Avenue
                    <br/>Brooklyn, NY</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex">
                            <img class="icon" src="assets/img/icons/theme/communication/call-1.svg" alt="call-1 icon"
                                 data-inject-svg/>
                            <div class="ml-3">
                                <span>+61 3928 3324</span>
                                <span class="d-block text-muted text-small">Mon - Fri 9am - 5pm</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex">
                            <img class="icon" src="assets/img/icons/theme/communication/mail.svg" alt="mail icon"
                                 data-inject-svg/>
                            <div class="ml-3">
                                <a href="#">hello@company.io</a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-5 col-xl-4 mt-3 mt-lg-0">
                    <h5>Subscribe</h5>
                    <p>The latest Leap news, articles, and resources, sent straight to your inbox every month.</p>
                    <form action="/forms/mailchimp.php" data-form-email novalidate>
                        <div class="form-row">
                            <div class="col-12">
                                <input type="email" class="form-control mb-2" placeholder="Email Address" name="email"
                                       required>
                            </div>
                            <div class="col-12">
                                <div class="d-none alert alert-success" role="alert" data-success-message>
                                    Thanks, a member of our team will be in touch shortly.
                                </div>
                                <div class="d-none alert alert-danger" role="alert" data-error-message>
                                    Please fill all fields correctly.
                                </div>
                                <div data-recaptcha data-sitekey="INSERT_YOUR_RECAPTCHA_V2_SITEKEY_HERE"
                                     data-size="invisible" data-badge="bottomleft">
                                </div>
                                <button type="submit" class="btn btn-primary btn-loading btn-block"
                                        data-loading-text="Sending">
                                    <img class="icon" src="assets/img/icons/theme/code/loading.svg" alt="loading icon"
                                         data-inject-svg/>
                                    <span>Subscribe</span>
                                </button>
                            </div>
                        </div>
                    </form>
                    <small class="text-muted form-text">We’ll never share your details. See our <a href="#">Privacy
                            Policy</a>
                    </small>

                </div>
            </div>
            <div class="row justify-content-center mb-2">
                <div class="col-auto">
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <img class="icon undefined" src="assets/img/icons/social/instagram.svg"
                                     alt="instagram social icon" data-inject-svg/>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <img class="icon undefined" src="assets/img/icons/social/twitter.svg"
                                     alt="twitter social icon" data-inject-svg/>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <img class="icon undefined" src="assets/img/icons/social/youtube.svg"
                                     alt="youtube social icon" data-inject-svg/>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <img class="icon undefined" src="assets/img/icons/social/medium.svg"
                                     alt="medium social icon" data-inject-svg/>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <img class="icon undefined" src="assets/img/icons/social/facebook.svg"
                                     alt="facebook social icon" data-inject-svg/>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col col-md-auto text-center">
                    <small class="text-muted">&copy;2019 This page is protected by reCAPTCHA and is subject to the
                        Google <a
                                href="https://www.google.com/policies/privacy/">Privacy Policy</a> and <a
                                href="https://policies.google.com/terms">Terms of Service.</a>
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
@endsection

@section('pageScript')
    @parent
@endsection

