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
                <div class="col-md-7 col-xl-6">
                    <div class="row justify-content-center">
                        <div class="col-xl-8 col-lg-10">
                            <span class="badge badge-primary">Коротко</span>
                            <div class="my-3">
                                <h1>Обо мне</h1>
                            </div>

                            <p class="lead">IT-эксперт с 19-летним опытом в <code><b>FinTech</b></code>,
                                крупном
                                цифровом бизнесе и стартапах. Строю и трансформирую инженерные организации, с фокусом
                                на ключевые бизнес-метрики: <code><b>Retention</b></code>, <code><b>LTV</b></code>,
                                <code><b>P&L</b></code>, <code><b>TTM</b></code>. Соединяю
                                глубокую
                                продуктовую экспертизу (управление командами, запуск CRM, мобильных
                                приложений) с
                                системной работой над процессами (<code><b>Agile</b></code>-трансформации, разработка
                                методологий) для достижения измеримых результатов.</p>
                            <br/>

                            <p class="lead">Сохраняю актуальную техническую экспертизу (<code><b>Go</b></code>,
                                <code><b>Swift</b></code>, <code><b>JS</b></code>, <code><b>CI/CD</b></code>) и активно
                                применяю современные <code><b>AI/ML</b></code>-технологии в рабочем стеке, нацеливая
                                разработку
                                на оптимизацию бизнес-показателей.</p>
                            <br/>
                            <p><b>Cертификаты:</b></p>
                            <ul>
                                <li>
                                    <a title="Официальный сертификат Амплеева Евгения Михайловича, подтверждающий, что он прошел курс Advanced Go Developer в Yandex Practicum®"
                                       href="/assets/pdf/ampleev_em_cert_advanced_golang_20242GP00104.pdf">Advanced Go
                                        Developer в Yandex Practicum®</a></li>
                                <li>
                                    <a title="Официальный сертификат Амплеева Евгения Михайловича, подтверждающий, что он прошел курс Advanced Management 3.0 в M 3.0®"
                                       href="/assets/pdf/your-management-3-0-certificate-2021-12-14.pdf">Advanced
                                        Management 3.0 в M 3.0®</a></li>
                                <li>
                                    <a title="Официальный сертификат Амплеева Евгения Михайловича, подтверждающий, что он прошел курс React JS в @mail.ru group®"
                                       href="/assets/pdf/react.pdf">React JS в @mail.ru group®</a></li>
                                <li>
                                    <a title="Официальный сертификат Амплеева Евгения Михайловича, подтверждающий, что он прошел курс Linux в @mail.ru group®"
                                       href="/assets/pdf/linux_level_1.pdf">Linux в @mail.ru group®</a></li>
                                <li>
                                    <a title="Официальный сертификат Амплеева Евгения Михайловича, подтверждающий, что он прошел курс Professional Backend Developer в @mail.ru group®"
                                       href="/assets/pdf/php_yii2.pdf">Professional Backend Developer в @mail.ru
                                        group®</a></li>
                                <li>
                                    <a title="Официальный сертификат Амплеева Евгения Михайловича, подтверждающий, что он прошел курс Data Bases - SQL в @mail.ru group® в @mail.ru group®"
                                       href="/assets/pdf/db_base_video.pdf">Data Bases - SQL в @mail.ru group®</a></li>
                                <li>
                                    <a title="Официальный сертификат Амплеева Евгения Михайловича, подтверждающий, что он прошел курс Git в @mail.ru group® в @mail.ru group®"
                                       href="/assets/pdf/git.pdf">Git в @mail.ru group®</a></li>
                                <li>
                                    <a title="Официальный сертификат Амплеева Евгения Михайловича, подтверждающий, что он прошел курс Web design в @mail.ru group®"
                                       href="/assets/pdf/web_design_base.pdf">Web design в @mail.ru group®</a></li>
                                {{--                                <li>--}}
                                {{--                                    <a title="Официальный сертификат Амплеева Евгения Михайловича, подтверждающий, что он прошел курс SAFe for teams в Ингосстрах®"--}}
                                {{--                                       href="/assets/pdf/safe_teams_compressed.pdf">SAFe for teams в Ингосстрах®</a>--}}
                                {{--                                </li>--}}
                                {{--                                <li>--}}
                                {{--                                    <a title="Официальный сертификат Амплеева Евгения Михайловича, подтверждающий, что он прошел курс SAFe for teams в Ингосстрах®"--}}
                                {{--                                       href="/assets/pdf/safe_sm_compressed.pdf">SAFe for sm в Ингосстрах®</a></li>--}}
                            </ul>
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
                    <div class="row mb-4">
                        <div class="col">
                            <h2 data-aos="fade-up">Карьера</h2>
                        </div>
                    </div>
                    <ol class="process-vertical">
                        <li data-aos="fade-left" data-aos-delay="100">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Ноябрь 2024</span>
                                <h5><a href="https://www.svo.aero/en/main">Sheremetyevo</a></h5>
                                <h4>Главный эксперт по методологии разработки</h4>
                            </div>
                        </li>
                        <li data-aos="fade-left" data-aos-delay="200">
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
                    </ol>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('pageScript')
    @parent
@endsection
