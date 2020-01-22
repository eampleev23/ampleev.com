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
                                <a href="index.html">Блог</a>
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
                    <span class="display-4 text-primary d-block" data-countup="" data-start="1" data-end="13"
                          data-duration="3" data-grouping="true" data-suffix=" лет">13</span>
                    <span class="h6">Общий опыт в IT</span>
                </div>
                <div class="col-6 mb-3 col-lg-3 mb-lg-0 aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                    <span class="display-4 text-primary d-block" data-countup="" data-start="1" data-end="25"
                          data-duration="3" data-grouping="true">25</span>
                    <span class="h6">Количество команд, с которыми работал</span>
                </div>
                <div class="col-6 mb-3 col-lg-3 mb-lg-0 aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
                    <span class="display-4 text-primary d-block" data-countup="" data-start="1" data-end="407"
                          data-duration="3" data-grouping="true">5,069</span>
                    <span class="h6">SP выполнено командами</span>
                </div>
                <div class="col-6 mb-3 col-lg-3 mb-lg-0 aos-init aos-animate" data-aos="fade-up" data-aos-delay="400">
                    <span class="display-4 text-primary d-block" data-countup="" data-start="1" data-end="87"
                          data-duration="3" data-grouping="true" data-suffix="%">87</span>
                    <span class="h6">Средний процент достижения целей в командах</span>
                </div>
            </div>
        </div>
    </section>

{{--    <section>--}}
{{--        <div class="container aos-init aos-animate" data-aos="fade-up">--}}
{{--            <div class="row align-items-center justify-content-around">--}}
{{--                <div class="col-md-5 col-xl-6 mb-4 mb-md-0">--}}
{{--                    <img src="assets/img/inner-2.jpg" alt="Image" class="rounded shadow-3d">--}}
{{--                </div>--}}
{{--                <div class="col-md-7 col-xl-6">--}}
{{--                    <div class="row justify-content-center">--}}
{{--                        <div class="col-xl-8 col-lg-10">--}}
{{--                            <span class="badge badge-primary">Коротко обо мне</span>--}}
{{--                            <div class="my-3">--}}
{{--                                <span class="h1">Стрессонеустойчивость</span>--}}
{{--                            </div>--}}
{{--                            <p class="lead">Конечно, это шутка. Я&nbspстрессоустойчив, как и все на hh.</p>--}}
{{--                            <p class="lead mb-0">А еще я верю в Agile с умом. <br/><br/> Верю и вижу на практике, что--}}
{{--                                этот набор--}}
{{--                                принципов действительно помогает людям испытывать меньше стресса в работе. <br/><br/>Достигать--}}
{{--                                более значимых результатов, чем в бизнес-процессах, использующих waterfall.</p>--}}
{{--                            <p class="lead mb-0"><br/><br/>И еще. Попробуйте угадать где я на картинке слева.<br/><br/>--}}
{{--                                Ответы можете присылать мне на почту, обещаю отвечать угадали или нет.--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}

{{--    <section class="p-0">--}}
{{--        <div class="container py-6">--}}
{{--            <div class="row mb-4 aos-init aos-animate" data-aos="fade-up">--}}
{{--                <div class="col">--}}
{{--                    <h2>Leadership Team</h2>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="row mb-3">--}}
{{--                <div class="col-xl-3 col-lg-4 col-md-6 aos-init aos-animate" data-aos="fade-up" data-aos-delay="NaN">--}}
{{--                    <div class="card card-lg card-body align-items-center">--}}
{{--                        <span class="badge badge-primary badge-top">Founder</span>--}}
{{--                        <img src="assets/img/avatars/female-1.jpg" alt="Kathleen Wong" class="avatar avatar-xlg mb-3">--}}
{{--                        <h5 class="mb-0">Kathleen Wong</h5>--}}
{{--                        <span>CEO</span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-xl-3 col-lg-4 col-md-6 aos-init aos-animate" data-aos="fade-up" data-aos-delay="NaN">--}}
{{--                    <div class="card card-lg card-body align-items-center">--}}
{{--                        <span class="badge badge-primary badge-top">Founder</span>--}}
{{--                        <img src="assets/img/avatars/male-2.jpg" alt="Anil Bhaktar" class="avatar avatar-xlg mb-3">--}}
{{--                        <h5 class="mb-0">Anil Bhaktar</h5>--}}
{{--                        <span>CTO</span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-xl-3 col-lg-4 col-md-6 aos-init aos-animate" data-aos="fade-up" data-aos-delay="NaN">--}}
{{--                    <div class="card card-lg card-body align-items-center">--}}
{{--                        <img src="assets/img/avatars/male-1.jpg" alt="Andrew Price" class="avatar avatar-xlg mb-3">--}}
{{--                        <h5 class="mb-0">Andrew Price</h5>--}}
{{--                        <span>Software Engineer</span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-xl-3 col-lg-4 col-md-6 aos-init aos-animate" data-aos="fade-up" data-aos-delay="NaN">--}}
{{--                    <div class="card card-lg card-body align-items-center">--}}
{{--                        <img src="assets/img/avatars/female-2.jpg" alt="Maya Sanders" class="avatar avatar-xlg mb-3">--}}
{{--                        <h5 class="mb-0">Maya Sanders</h5>--}}
{{--                        <span>Experience Designer</span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-xl-3 col-lg-4 col-md-6 aos-init aos-animate" data-aos="fade-up" data-aos-delay="NaN">--}}
{{--                    <div class="card card-lg card-body align-items-center">--}}
{{--                        <img src="assets/img/avatars/male-4.jpg" alt="Marco Schneider" class="avatar avatar-xlg mb-3">--}}
{{--                        <h5 class="mb-0">Marco Schneider</h5>--}}
{{--                        <span>Experience Designer</span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-xl-3 col-lg-4 col-md-6 aos-init aos-animate" data-aos="fade-up" data-aos-delay="NaN">--}}
{{--                    <div class="card card-lg card-body align-items-center">--}}
{{--                        <img src="assets/img/avatars/female-4.jpg" alt="Helena Price" class="avatar avatar-xlg mb-3">--}}
{{--                        <h5 class="mb-0">Helena Price</h5>--}}
{{--                        <span>Marketing</span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-xl-3 col-lg-4 col-md-6 aos-init aos-animate" data-aos="fade-up" data-aos-delay="NaN">--}}
{{--                    <div class="card card-lg card-body align-items-center">--}}
{{--                        <img src="assets/img/avatars/male-5.jpg" alt="Kenneth O'Dowd" class="avatar avatar-xlg mb-3">--}}
{{--                        <h5 class="mb-0">Kenneth O'Dowd</h5>--}}
{{--                        <span>Strategy</span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="row">--}}
{{--                <div class="col">--}}
{{--            <span>Interested in joining our team? <a href="#">View career openings</a>--}}
{{--            </span>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="divider" style="">--}}
{{--            <img class="decoration bg-primary-alt" src="" alt="divider graphic" data-inject-svg="">--}}
{{--        </div>--}}
{{--    </section>--}}

    <section class="bg-primary-alt o-hidden">
        <div class="container">
            <div class="row mb-4">
                <div class="col">
                    <h2>Our History</h2>
                </div>
            </div>
            <div class="row o-hidden o-lg-visible">
                <div class="col d-flex flex-column align-items-center">
                    <ol class="process-vertical">
                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">October 2016</span>
                                <h5 class="mb-0">Secured Series-A funding</h5>
                            </div>
                        </li>
                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">April 2017</span>
                                <h5 class="mb-0">New CTO: Joe Schultz</h5>
                            </div>
                        </li>
                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">October 2017</span>
                                <h5 class="mb-0">v1.0 Ships</h5>
                            </div>
                        </li>
                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">February 2018</span>
                                <h5 class="mb-0">Featured in Wired</h5>
                            </div>
                        </li>
                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">September 2018</span>
                                <h5 class="mb-0">v.20 Ships</h5>
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