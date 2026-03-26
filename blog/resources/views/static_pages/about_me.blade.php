@extends('layouts.app')

@section('title', 'Обо мне')
@section('description', 'На данной странице вы получите исчерпывающую информацию обо мне')
@section('page_url', route('static_pages.about_me'))

@section('custom_css')
    @parent
@endsection

@section('sidebar')
    @parent
    <link href="assets/css/custom.css?v={{ filemtime(public_path('assets/css/custom.css')) }}" rel="stylesheet"
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
                    <img src="assets/img/about_me_11_03.PNG" alt="Image" class="rounded shadow-3d">
                </div>
                {{--                init commit --}}
                <div class="col-md-7 col-xl-6">
                    <div class="row justify-content-center">
                        <div class="col-xl-8 col-lg-10">
                            <span class="badge badge-primary">Коротко</span>
                            <div class="my-3">
                                <h1>Обо мне</h1>
                            </div>
                            <p class="lead">IT-менеджер с опытом в <code><b>FinTech</b></code>,
                                крупном
                                цифровом бизнесе и стартапах. Работаю с фокусом
                                на ключевые бизнес-метрики: <code><b>Retention</b></code>, <code><b>LTV</b></code>,
                                <code><b>P&L</b></code>, <code><b>TTM</b></code>. Имею опыт в управлении
                                командами, запуске и развитии it-продуктов (CRM, мобильные приложения),
                                системной работе над процессами (<code><b>Agile</b></code>-трансформации, разработка
                                методологий).</p>
                            <br/>

                            <p class="lead">Сохраняю актуальную техническую экспертизу (<code><b>Go</b></code>,
                                <code><b>Swift</b></code>, <code><b>JS</b></code>, <code><b>CI/CD</b></code>) и
                                применяю <code><b>AI/ML</b></code>-технологии.</p>
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
