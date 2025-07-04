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
                                {{--                                <a href="{{route('blog.blog')}}">Блог</a>--}}
                                <a href="{{route('blog.blog')}}">Блог</a>
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
                    <span class="display-4 text-primary d-block" data-countup="" data-start="0" data-end="19"
                          data-duration="3" data-grouping="true" data-suffix=" лет">17</span>
                    <span class="h6">Общий опыт в IT</span>
                </div>
                <div class="col-6 mb-3 col-lg-3 mb-lg-0 aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                    <span class="display-4 text-primary d-block" data-countup="" data-start="0" data-end="62"
                          data-duration="3" data-grouping="true">62</span>
                    <span class="h6">Количество команд, с которыми работал</span>
                </div>
                <div class="col-6 mb-3 col-lg-3 mb-lg-0 aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
                    <span class="display-4 text-primary d-block" data-countup="" data-start="0" data-end="97"
                          data-duration="3" data-grouping="true">97</span>
                    <span class="h6">Количество обученных Скрам&nbspМастеров</span>
                </div>
                <div class="col-6 mb-3 col-lg-3 mb-lg-0 aos-init aos-animate" data-aos="fade-up" data-aos-delay="400">
                    <span class="display-4 text-primary d-block" data-countup="" data-start="-100" data-end="9"
                          data-duration="3" data-grouping="true" data-suffix=" из 10">9 из 10</span>
                    <span class="h6">Средняя обратная связь по фасилитации</span>
                </div>
                <br/>
                <br/>
                <div class="col-6 mb-3 col-lg-3 mb-lg-0 aos-init aos-animate" data-aos="fade-up" data-aos-delay="300"
                     style="margin-top: 80px">
                                    <span class="display-4 text-primary d-block" data-countup="" data-start="0"
                                          data-end="3"
                                          data-duration="1" data-grouping="true">3</span>
                    <span class="h6">Количество разработанных методик</span>
                </div>

                <div class="col-6 mb-3 col-lg-3 mb-lg-0 aos-init aos-animate" data-aos="fade-up" data-aos-delay="300"
                     style="margin-top: 80px">
                                    <span class="display-4 text-primary d-block" data-countup="" data-start="0"
                                          data-end="397"
                                          data-duration="3" data-grouping="true">397</span>
                    <span class="h6">Количество людей, работающих по разработанным методикам</span>
                </div>

                {{--                                <div class="col-6 mb-3 col-lg-3 mb-lg-0 aos-init aos-animate" data-aos="fade-up" data-aos-delay="300"style="margin-top: 10px">--}}
                {{--                                    <span class="display-4 text-primary d-block" data-countup="" data-start="0" data-end="6"--}}
                {{--                                          data-duration="3" data-grouping="true">6</span>--}}
                {{--                                    <span class="h6">Опыт ментора Скрам Мастеров</span>--}}
                {{--                                </div>--}}

                {{--                <div class="col-6 mb-3 col-lg-3 mb-lg-0 aos-init aos-animate" data-aos="fade-up" data-aos-delay="300"style="margin-top: 10px">--}}
                {{--                                    <span class="display-4 text-primary d-block" data-countup="" data-start="0"--}}
                {{--                                          data-end="7"--}}
                {{--                                          data-duration="3" data-grouping="true">7</span>--}}
                {{--                    <span class="h6">Опыт в гибких фреймворках</span>--}}
                {{--                </div>--}}

            </div>
        </div>
    </section>

    <section>
        <div class="container aos-init aos-animate" data-aos="fade-up">
            <div class="row align-items-center justify-content-around">
                <div class="col-md-5 col-xl-6 mb-4 mb-md-0">
                    <img src="assets/img/IMG_7446.jpg" alt="Image" class="rounded shadow-3d">
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
                                полезно в IT-менеджменте.</p>
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
                                <span class="text-small text-muted">Март 2025</span>
                                <h5 class="mb-0"><a
                                        href="https://www.ampleev.com/blog">Новые
                                        публикации
                                        в блоге</a>
                                    <br/><a href="https://ampleev.com/"> <img
                                            alt="Блог Ampleev.com"
                                            title="Блог Ampleev.com" width="87px"
                                            src="mstile-70x70.png"
                                            style="padding-bottom: 16px;"></a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Ноябрь 2024</span><br/>
                                <h5>Главный эксперт по методологии разработки в </h5>
                                <a href="https://www.svo.aero/en/main" class="mb-0">
                                    <img alt="Sheremetyevo" title="Sheremetyevo" width="347px"
                                         src="assets/img/logo-eng_svo.svg" style="padding-bottom: 16px;">
                                </a>

                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Ноябрь 2024</span>
                                <h5 class="mb-0">Закончил обучение в Яндекс Практикум по специализации
                                    <a href="/assets/pdf/EVGENII AMPLEEV_20242GP00104.pdf">Продвинутый Golang
                                        разработчик</a> в <a href="https://practicum.yandex.ru/go-advanced/"><img
                                            alt="Продвинутый Go‑разработчик"
                                            title="Продвинутый Go‑разработчик" width="87px"
                                            src="assets/img/Yandex_znak.svg"
                                            style="
    padding-bottom: 16px;
"></a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Сентябрь 2024</span><br/>
                                <a class="mb-0">Закончил работать в
                                    <svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                         width="200px" height="100px" viewBox="70 440 700 400"
                                         xml:space="preserve">
                                            <g transform="scale(1.5)">

                                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M151.425,421.68c0,28.78-23.344,52.135-52.103,52.135
	c-28.761,0-52.105-23.355-52.105-52.135c0-28.779,23.344-52.131,52.105-52.131C128.081,369.549,151.425,392.901,151.425,421.68"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" d="M48.089,421.68c0-28.272,22.971-51.264,51.233-51.264
	c28.199,0,51.17,22.991,51.17,51.264c0,28.216-22.971,51.195-51.17,51.195C71.06,472.875,48.089,449.896,48.089,421.68
	 M46.279,421.68c0,29.213,23.784,53.002,53.043,53.002c29.19,0,52.97-23.789,52.97-53.002c0-29.278-23.779-53.063-52.97-53.063
	C70.063,368.617,46.279,392.402,46.279,421.68"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" d="M133.063,416.261c-0.436,0.373-0.871,0.681-1.303,1.062
	c-2.931,2.233-7.601,4.045-14.009,5.732c-13.319,3.607-22.979,4.098-33.938,6.789c-2.175,0.556-4.416,1.24-6.465,2.112
	c2.049,1.062,4.29,1.994,6.532,2.869c4.479-1.305,6.605-1.868,13.07-2.927c2.491-0.445,10.087-1.812,15.565-2.922
	C122.42,426.849,136.924,422.239,133.063,416.261 M126.654,403.801c-2.126-0.929-4.74-1.869-7.533-2.61
	c-1.255,0.997-2.677,1.864-4.804,2.683c3.496,0.612,6.111,1.609,9.09,2.424C123.906,406.549,126.271,404.376,126.654,403.801
	 M78.153,417.071c12.951-3.802,26.524-4.981,40.283-8.654c-5.354-1.431-8.352-2.059-14.004-1.37
	c-8.223,0.997-17.313,2.732-25.091,5.042c-3.057,0.937-19.053,5.48-14.44,11.832C64.9,423.986,67.63,420.128,78.153,417.071
	 M69.25,438.867c-0.063,1.188,0.689,2.245,2.246,3.555c0.183-0.629,0.499-1.119,0.935-1.743
	C71.368,440.111,70.308,439.556,69.25,438.867 M75.293,438.315c0.991-0.628,2.17-1.191,3.478-1.687
	c-1.802-0.814-3.731-1.613-5.6-2.488c-0.872,0.56-1.676,1.119-2.298,1.674C72.363,436.69,73.8,437.497,75.293,438.315
	 M125.027,410.785c-2.606,1.245-6.341,2.485-11.696,3.798c-4.42,1.118-15.129,2.675-26.643,5.164
	c-3.612,0.811-13.516,3.112-18.372,7.223c1.37,1.131,2.241,1.374,3.735,2.246c1.992-1.31,4.732-2.554,8.784-3.62
	c7.026-1.86,12.324-2.667,18.678-3.721c6.285-0.949,18.171-3.434,24.709-5.805c2.183-0.742,4.171-1.739,5.6-2.931
	C129.384,412.649,125.152,410.594,125.027,410.785 M128.829,408.474c1.303,0.625,2.495,1.062,3.611,1.873
	c0.805-1.561,0.306-2.558-1.366-3.988C130.386,407.173,129.634,407.854,128.829,408.474 M68.631,431.83
	c-1.188-0.616-1.933-1.115-2.931-1.743c-0.499,1.127,0.507,2.363,1.498,2.931C67.63,432.58,68.196,432.207,68.631,431.83
	 M123.657,396.087c-0.25,0.872-1.173,1.93-1.802,2.619c1.932,0.499,3.924,1.236,5.787,1.925
	C127.396,398.888,125.404,397.206,123.657,396.087 M62.774,407.1c13.573-8.84,28.579-14.069,53.976-9.643
	c1.37-0.815,2.176-1.625,2.558-3.243c-6.356-2.302-13.261-3.113-22.16-2.992c-7.975,0.251-22.357,3.235-30.068,7.791l2.357-2.927
	c5.354-3.186,19.359-7.353,29.886-7.543c7.403-0.182,11.201,0.248,20.044,2.615c-0.814-1.484-2.616-2.238-5.294-3.482
	c-8.524-3.802-24.401-4.179-37.409,1.613c1.613-1.119,3.233-2.12,5.355-3.04c4.287-1.998,11.327-3.932,20.101-3.745
	c7.041,0.125,15.383,2.554,20.484,7.6c0.867,1.054,1.37,2.112,1.556,2.927c4.048,2.055,6.409,3.984,7.716,6.226
	c0.565,1.184,0.752,2.428,0.499,3.859c1.68,0.993,2.495,1.869,3.371,3c0.551,0.932,0.987,1.982,1.117,2.931
	c0.182,1.236,0.306,2.671-1.001,4.354c1.37,0.689,2.487,2.61,2.621,3.429c0.681,3.04-1.313,6.031-3.861,8.342
	c-2.993,2.61-9.592,5.728-14.947,7.102c-10.576,2.672-19.981,3.799-27.444,5.169c3.358,0.807,7.902,1.872,15.312,1.872
	c15.867,0,29.875-7.482,29.875-7.482s-0.306,0.944-0.622,1.816c-10.085,6.1-26.078,8.649-32.932,8.338
	c-6.911-0.316-12.758-1.37-18.486-3.117c-1.745,0.502-3.488,1.065-5.164,1.747c8.717,3.984,15.312,4.859,22.722,5.415
	c7.59,0.567,20.172-1.248,30.747-5.1c-0.498,0.503-0.746,1.245-1.24,1.683c-5.421,2.861-16.868,5.728-22.659,5.975
	c-5.733,0.251-12.701,0-18.804-1.123c-5.229-1.054-9.53-2.683-14.009-4.665c-0.804,0.612-1.177,1.37-1.37,2.241
	c17.501,9.153,33.804,9.339,52.425,3.547l-1.69,1.621c-20.48,8.347-36.477,5.104-48.87-0.871c-0.432-0.19-0.93-0.381-1.299-0.628
	c1.184,1.998,10.638,8.909,21.222,9.78c7.29,0.624,16.189-0.624,21.481-2.735l-3.109,1.613c-2.558,1.248-9.339,4.118-18.808,3.493
	c-12.634-0.875-19.736-6.481-22.908-9.403c-1.498-1.379-2.175-2.931-2.615-4.86c-2.864-1.496-4.669-3.057-6.159-5.424
	c-0.872-1.305-0.689-2.857-0.502-4.175l0.383-1.11c-1.374-1.005-2.807-2.063-3.366-3.113c-1.25-2.245-0.495-4.183,0.373-5.675
	c-0.752-0.871-1.437-1.743-1.739-2.614c-0.373-0.997-0.436-2.003-0.32-3.117c0.249-1.865,1.25-3.607,2.558-5.107
	c2.734-3.174,7.102-5.667,14.501-8.095c7.29-2.432,10.217-2.809,15.695-4.058c6.409-1.487,14.067-1.982,20.48-4.224
	c-17.874-3.113-36.418-0.251-51.547,10.142L62.774,407.1z"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" d="M219.095,412.402l2.055,14.2h-4.114L219.095,412.402z
	 M203.098,444.85h10.892l1.37-8.038h7.533l1.308,8.038h10.892l-9.216-46.464h-13.568L203.098,444.85z"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" d="M245.426,416.391c1.739,0,4.919-1.123,4.919-4.548
	c0-4.045-3.672-4.301-4.736-4.301c-1.24,0-3.605,0.19-5.91,1.313l-0.124-10.097c3.672-0.933,6.287-1.184,9.396-1.184
	c8.847,0,12.768,6.169,12.768,12.205c0,5.861-3.366,9.404-6.662,10.778v0.434c3.176,1.005,7.405,4.05,7.405,11.151
	c0,8.787-6.098,13.64-13.943,13.64c-4.171-0.057-6.911-0.616-10.211-2.424l0.187-9.659c3.052,1.313,5.105,1.435,7.161,1.435
	c3.488,0,4.852-2.558,4.852-4.419c0-2.618-1.676-4.361-5.351-4.361h-4.357v-9.963H245.426z"/>
                                                <polygon fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" points="267.525,398.385 296.908,398.385 296.908,444.85
	286.137,444.85 286.137,409.597 278.295,409.597 278.295,444.85 267.525,444.85 "/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" d="M313.84,408.6h2.554c2.432,0,3.988,1.496,3.988,5.359
	c0,4.982-2.618,5.351-3.988,5.351h-2.554V408.6z M303.071,444.85h10.769v-15.318h3.615c10.641,0,13.944-9.594,13.944-15.707
	c0-5.975-3.803-15.439-13.944-15.439h-14.384V444.85z"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" d="M351.317,434.137c-3.802,0-5.724-4.418-5.724-12.578
	c0-8.164,1.922-12.582,5.724-12.582c3.803,0,5.724,4.418,5.724,12.582C357.041,429.719,355.12,434.137,351.317,434.137
	 M351.317,445.413c12.765,0,17.053-11.962,17.053-23.854s-4.288-23.854-17.053-23.854c-12.76,0-17.053,11.962-17.053,23.854
	S338.558,445.413,351.317,445.413"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" d="M425.836,435.507v-10.523h1.557c1.305,0,4.67,0.062,4.67,4.856
	c0,4.864-3.365,5.667-4.67,5.667H425.836z M415.313,444.85h12.825c2.797,0,14.442-1.188,14.503-15.266
	c0-11.819-9.023-13.878-14.876-13.878h-1.93v-6.169h14.256v-11.147h-24.778V444.85z"/>
                                                <polygon fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" points="481.368,398.385 491.887,398.385 491.887,415.142
	499.422,415.142 499.422,398.385 509.937,398.385 509.937,444.85 499.422,444.85 499.422,426.229 491.887,426.229 491.887,444.85
	481.368,444.85 "/>
                                                <polygon fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" points="517.03,398.385 527.617,398.385 527.553,415.077
	529.855,415.077 535.895,398.385 547.35,398.385 539.129,420.44 548.533,444.85 536.142,444.85 530.046,426.163 527.553,426.163
	527.617,444.85 517.03,444.85 "/>
                                                <polygon fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" points="182.245,398.385 204.334,398.385 204.334,409.97
	193.197,409.97 193.197,444.85 182.245,444.85 "/>
                                                <polygon fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" points="373.547,398.385 382.699,398.385 390.782,409.35
	398.945,398.385 408.033,398.385 408.033,444.85 397.255,444.85 397.255,416.508 390.782,424.606 384.313,416.508 384.313,444.85
	373.547,444.85 "/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" d="M460.76,412.523l1.99,14.139h-4.049L460.76,412.523z M444.7,444.91
	h10.957l1.31-8.033h7.526l1.31,8.033h10.956l-9.213-46.456h-13.575L444.7,444.91z"/>
                                            </g>
                                    </svg>
                                </a>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Февраль 2024</span>
                                <h5 class="mb-0" style="margin-top: -30px;margin-left: -16px;"> &nbsp;&nbsp;&nbsp;Исполнительный
                                    директор в
                                    <a href="https://www.gazprombank.ru">
                                        <svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                             width="200px" height="100px" viewBox="70 440 700 400"
                                             xml:space="preserve">
                                            <g transform="scale(1.5)">

                                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M151.425,421.68c0,28.78-23.344,52.135-52.103,52.135
	c-28.761,0-52.105-23.355-52.105-52.135c0-28.779,23.344-52.131,52.105-52.131C128.081,369.549,151.425,392.901,151.425,421.68"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" d="M48.089,421.68c0-28.272,22.971-51.264,51.233-51.264
	c28.199,0,51.17,22.991,51.17,51.264c0,28.216-22.971,51.195-51.17,51.195C71.06,472.875,48.089,449.896,48.089,421.68
	 M46.279,421.68c0,29.213,23.784,53.002,53.043,53.002c29.19,0,52.97-23.789,52.97-53.002c0-29.278-23.779-53.063-52.97-53.063
	C70.063,368.617,46.279,392.402,46.279,421.68"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" d="M133.063,416.261c-0.436,0.373-0.871,0.681-1.303,1.062
	c-2.931,2.233-7.601,4.045-14.009,5.732c-13.319,3.607-22.979,4.098-33.938,6.789c-2.175,0.556-4.416,1.24-6.465,2.112
	c2.049,1.062,4.29,1.994,6.532,2.869c4.479-1.305,6.605-1.868,13.07-2.927c2.491-0.445,10.087-1.812,15.565-2.922
	C122.42,426.849,136.924,422.239,133.063,416.261 M126.654,403.801c-2.126-0.929-4.74-1.869-7.533-2.61
	c-1.255,0.997-2.677,1.864-4.804,2.683c3.496,0.612,6.111,1.609,9.09,2.424C123.906,406.549,126.271,404.376,126.654,403.801
	 M78.153,417.071c12.951-3.802,26.524-4.981,40.283-8.654c-5.354-1.431-8.352-2.059-14.004-1.37
	c-8.223,0.997-17.313,2.732-25.091,5.042c-3.057,0.937-19.053,5.48-14.44,11.832C64.9,423.986,67.63,420.128,78.153,417.071
	 M69.25,438.867c-0.063,1.188,0.689,2.245,2.246,3.555c0.183-0.629,0.499-1.119,0.935-1.743
	C71.368,440.111,70.308,439.556,69.25,438.867 M75.293,438.315c0.991-0.628,2.17-1.191,3.478-1.687
	c-1.802-0.814-3.731-1.613-5.6-2.488c-0.872,0.56-1.676,1.119-2.298,1.674C72.363,436.69,73.8,437.497,75.293,438.315
	 M125.027,410.785c-2.606,1.245-6.341,2.485-11.696,3.798c-4.42,1.118-15.129,2.675-26.643,5.164
	c-3.612,0.811-13.516,3.112-18.372,7.223c1.37,1.131,2.241,1.374,3.735,2.246c1.992-1.31,4.732-2.554,8.784-3.62
	c7.026-1.86,12.324-2.667,18.678-3.721c6.285-0.949,18.171-3.434,24.709-5.805c2.183-0.742,4.171-1.739,5.6-2.931
	C129.384,412.649,125.152,410.594,125.027,410.785 M128.829,408.474c1.303,0.625,2.495,1.062,3.611,1.873
	c0.805-1.561,0.306-2.558-1.366-3.988C130.386,407.173,129.634,407.854,128.829,408.474 M68.631,431.83
	c-1.188-0.616-1.933-1.115-2.931-1.743c-0.499,1.127,0.507,2.363,1.498,2.931C67.63,432.58,68.196,432.207,68.631,431.83
	 M123.657,396.087c-0.25,0.872-1.173,1.93-1.802,2.619c1.932,0.499,3.924,1.236,5.787,1.925
	C127.396,398.888,125.404,397.206,123.657,396.087 M62.774,407.1c13.573-8.84,28.579-14.069,53.976-9.643
	c1.37-0.815,2.176-1.625,2.558-3.243c-6.356-2.302-13.261-3.113-22.16-2.992c-7.975,0.251-22.357,3.235-30.068,7.791l2.357-2.927
	c5.354-3.186,19.359-7.353,29.886-7.543c7.403-0.182,11.201,0.248,20.044,2.615c-0.814-1.484-2.616-2.238-5.294-3.482
	c-8.524-3.802-24.401-4.179-37.409,1.613c1.613-1.119,3.233-2.12,5.355-3.04c4.287-1.998,11.327-3.932,20.101-3.745
	c7.041,0.125,15.383,2.554,20.484,7.6c0.867,1.054,1.37,2.112,1.556,2.927c4.048,2.055,6.409,3.984,7.716,6.226
	c0.565,1.184,0.752,2.428,0.499,3.859c1.68,0.993,2.495,1.869,3.371,3c0.551,0.932,0.987,1.982,1.117,2.931
	c0.182,1.236,0.306,2.671-1.001,4.354c1.37,0.689,2.487,2.61,2.621,3.429c0.681,3.04-1.313,6.031-3.861,8.342
	c-2.993,2.61-9.592,5.728-14.947,7.102c-10.576,2.672-19.981,3.799-27.444,5.169c3.358,0.807,7.902,1.872,15.312,1.872
	c15.867,0,29.875-7.482,29.875-7.482s-0.306,0.944-0.622,1.816c-10.085,6.1-26.078,8.649-32.932,8.338
	c-6.911-0.316-12.758-1.37-18.486-3.117c-1.745,0.502-3.488,1.065-5.164,1.747c8.717,3.984,15.312,4.859,22.722,5.415
	c7.59,0.567,20.172-1.248,30.747-5.1c-0.498,0.503-0.746,1.245-1.24,1.683c-5.421,2.861-16.868,5.728-22.659,5.975
	c-5.733,0.251-12.701,0-18.804-1.123c-5.229-1.054-9.53-2.683-14.009-4.665c-0.804,0.612-1.177,1.37-1.37,2.241
	c17.501,9.153,33.804,9.339,52.425,3.547l-1.69,1.621c-20.48,8.347-36.477,5.104-48.87-0.871c-0.432-0.19-0.93-0.381-1.299-0.628
	c1.184,1.998,10.638,8.909,21.222,9.78c7.29,0.624,16.189-0.624,21.481-2.735l-3.109,1.613c-2.558,1.248-9.339,4.118-18.808,3.493
	c-12.634-0.875-19.736-6.481-22.908-9.403c-1.498-1.379-2.175-2.931-2.615-4.86c-2.864-1.496-4.669-3.057-6.159-5.424
	c-0.872-1.305-0.689-2.857-0.502-4.175l0.383-1.11c-1.374-1.005-2.807-2.063-3.366-3.113c-1.25-2.245-0.495-4.183,0.373-5.675
	c-0.752-0.871-1.437-1.743-1.739-2.614c-0.373-0.997-0.436-2.003-0.32-3.117c0.249-1.865,1.25-3.607,2.558-5.107
	c2.734-3.174,7.102-5.667,14.501-8.095c7.29-2.432,10.217-2.809,15.695-4.058c6.409-1.487,14.067-1.982,20.48-4.224
	c-17.874-3.113-36.418-0.251-51.547,10.142L62.774,407.1z"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" d="M219.095,412.402l2.055,14.2h-4.114L219.095,412.402z
	 M203.098,444.85h10.892l1.37-8.038h7.533l1.308,8.038h10.892l-9.216-46.464h-13.568L203.098,444.85z"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" d="M245.426,416.391c1.739,0,4.919-1.123,4.919-4.548
	c0-4.045-3.672-4.301-4.736-4.301c-1.24,0-3.605,0.19-5.91,1.313l-0.124-10.097c3.672-0.933,6.287-1.184,9.396-1.184
	c8.847,0,12.768,6.169,12.768,12.205c0,5.861-3.366,9.404-6.662,10.778v0.434c3.176,1.005,7.405,4.05,7.405,11.151
	c0,8.787-6.098,13.64-13.943,13.64c-4.171-0.057-6.911-0.616-10.211-2.424l0.187-9.659c3.052,1.313,5.105,1.435,7.161,1.435
	c3.488,0,4.852-2.558,4.852-4.419c0-2.618-1.676-4.361-5.351-4.361h-4.357v-9.963H245.426z"/>
                                                <polygon fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" points="267.525,398.385 296.908,398.385 296.908,444.85
	286.137,444.85 286.137,409.597 278.295,409.597 278.295,444.85 267.525,444.85 "/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" d="M313.84,408.6h2.554c2.432,0,3.988,1.496,3.988,5.359
	c0,4.982-2.618,5.351-3.988,5.351h-2.554V408.6z M303.071,444.85h10.769v-15.318h3.615c10.641,0,13.944-9.594,13.944-15.707
	c0-5.975-3.803-15.439-13.944-15.439h-14.384V444.85z"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" d="M351.317,434.137c-3.802,0-5.724-4.418-5.724-12.578
	c0-8.164,1.922-12.582,5.724-12.582c3.803,0,5.724,4.418,5.724,12.582C357.041,429.719,355.12,434.137,351.317,434.137
	 M351.317,445.413c12.765,0,17.053-11.962,17.053-23.854s-4.288-23.854-17.053-23.854c-12.76,0-17.053,11.962-17.053,23.854
	S338.558,445.413,351.317,445.413"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" d="M425.836,435.507v-10.523h1.557c1.305,0,4.67,0.062,4.67,4.856
	c0,4.864-3.365,5.667-4.67,5.667H425.836z M415.313,444.85h12.825c2.797,0,14.442-1.188,14.503-15.266
	c0-11.819-9.023-13.878-14.876-13.878h-1.93v-6.169h14.256v-11.147h-24.778V444.85z"/>
                                                <polygon fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" points="481.368,398.385 491.887,398.385 491.887,415.142
	499.422,415.142 499.422,398.385 509.937,398.385 509.937,444.85 499.422,444.85 499.422,426.229 491.887,426.229 491.887,444.85
	481.368,444.85 "/>
                                                <polygon fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" points="517.03,398.385 527.617,398.385 527.553,415.077
	529.855,415.077 535.895,398.385 547.35,398.385 539.129,420.44 548.533,444.85 536.142,444.85 530.046,426.163 527.553,426.163
	527.617,444.85 517.03,444.85 "/>
                                                <polygon fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" points="182.245,398.385 204.334,398.385 204.334,409.97
	193.197,409.97 193.197,444.85 182.245,444.85 "/>
                                                <polygon fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" points="373.547,398.385 382.699,398.385 390.782,409.35
	398.945,398.385 408.033,398.385 408.033,444.85 397.255,444.85 397.255,416.508 390.782,424.606 384.313,416.508 384.313,444.85
	373.547,444.85 "/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" fill="#1E3262" d="M460.76,412.523l1.99,14.139h-4.049L460.76,412.523z M444.7,444.91
	h10.957l1.31-8.033h7.526l1.31,8.033h10.956l-9.213-46.456h-13.575L444.7,444.91z"/>
                                            </g>
</svg>
                                    </a>
                                </h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Октябрь 2023</span>
                                <h5 class="mb-0">Обучение в Яндекс Практикум по специализации <a
                                        href="https://practicum.yandex.ru/go-advanced/">&#171;Продвинутый Go‑разработчик&#187;</a>
                                    в<a href="https://practicum.yandex.ru/go-advanced/"><img
                                            alt="Продвинутый Go‑разработчик"
                                            title="Продвинутый Go‑разработчик" width="87px"
                                            src="assets/img/Yandex_znak.svg"
                                            style="
    padding-bottom: 16px;
"></a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Октябрь 2023</span>
                                <h5 class="mb-0"> &nbsp;&nbsp;&nbsp;Закончил работать в &nbsp
                                    <a href="https://www.vtb.ru/">VTB</a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Декабрь 2021</span>
                                <h5 class="mb-0">Прошел тренинг <a
                                        href="/assets/pdf/your-management-3-0-certificate-2021-12-14.pdf">&#171;Advanced
                                        Management 3.0&#187;</a>
                                    в<a href="https://management30.com"><img alt="Management 3.0"
                                                                             title="Management 3.0" width="87px"
                                                                             src="assets/img/m30-logo.png"
                                                                             style="
    padding-bottom: 16px;
"></a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Февраль 2021</span>
                                <h5 class="mb-0"> &nbsp;&nbsp;&nbsp;Agile Coach в &nbsp
                                    <a href="https://www.vtb.ru/"><img alt="ВТБ" title="ВТБ" width="87px"
                                                                       src="assets/img/logo-new-engVTB.svg"
                                                                       style="
    padding-bottom: 16px;
"></a></h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Февраль 2021</span>
                                <h5 class="mb-0"> &nbsp;&nbsp;&nbsp;Закончил работать в
                                    <a href="https://alfabank.ru">Альфа Банк</a></h5>
                            </div>
                        </li>


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


                                    Окончил курс <a href="/assets/pdf/web_design_base.pdf">&#171;Основы
                                        Веб-дизайна&#187;</a>
                                    в <a href="https://geekbrains.ru/">Geekbrains</a>
                                </h5>
                            </div>
                        </li>

                        <li data-aos="fade-left" class="aos-init aos-animate">
                            <div class="process-circle bg-primary"></div>
                            <div>
                                <span class="text-small text-muted">Март 2019</span>
                                <h5 class="mb-0">
                                    Окончил тренинг Golang (основы синтаксиса) в <a
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
