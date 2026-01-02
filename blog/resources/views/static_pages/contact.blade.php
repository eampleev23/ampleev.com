@extends('layouts.app')

@section('title', 'Связаться')
@section('description', 'Свяжитесь со мной по любым вопросам: email, телефон или форма обратной связи.')
@section('page_url', route('static_pages.contact'))
@section('main_image_path', url('/assets/img/contact_bgr.jpg'))

@section('custom_css')
    @parent
    <style>
        #contact-map {
            width: 100%;
            height: 360px;
        }
    </style>
@endsection

@section('content')
    @include('layouts.navbar_white')

    <section class="has-divider text-light jarallax bg-dark" data-jarallax data-speed="0.4" data-overlay
             style="background-image: url('/assets/img/contact_bgr.jpg');">
        <div class="container py-5">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <span class="badge badge-primary">Контакты</span>
                    <h1 class="display-4 mt-3 mb-3">Свяжитесь со мной</h1>
                    <p class="lead mb-0">Есть вопрос или идея для сотрудничества? Оставьте сообщение, и я отвечу.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-0">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-4 mb-4">
                    <h5 class="mb-2">Посетить</h5>
                    <p class="mb-0">Паршина, 10<br>Москва</p>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5 class="mb-2">Email</h5>
                    <a href="mailto:support@mpleev.com">support@mpleev.com</a>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5 class="mb-2">Позвонить</h5>
                    <p class="mb-0">+79 9578 32277<br><span class="text-muted text-small">Пн - Пт, 9:00–17:00</span></p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-light">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div id="contact-map" class="rounded shadow"></div>
                </div>
                <div class="col-lg-5">
                    <div class="card shadow">
                        <div class="card-body p-4">
                            <h3 class="mb-3">Оставить сообщение</h3>
                            <p class="text-muted mb-4">Заполните поля, отмеченные звёздочкой. Остальные — по желанию.</p>

                            @if(session('contact_success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('contact_success') }}
                                </div>
                            @endif
                            @if($errors->has('form'))
                                <div class="alert alert-danger" role="alert">
                                    {{ $errors->first('form') }}
                                </div>
                            @endif

                            <form id="contact-form" method="POST" action="{{ route('static_pages.contact_submit') }}" novalidate>
                                @csrf
                                <input type="text" name="contact_trap" class="d-none" tabindex="-1" autocomplete="off">
                                <input type="hidden" name="recaptcha_token" id="recaptcha-token">

                                <div class="form-group">
                                    <label for="contact-name">Ваше имя *</label>
                                    <input type="text" name="name" id="contact-name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="contact-email">Email *</label>
                                    <input type="email" name="email" id="contact-email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="contact-company">Компания</label>
                                    <input type="text" name="company" id="contact-company"
                                           class="form-control @error('company') is-invalid @enderror"
                                           value="{{ old('company') }}">
                                    @error('company')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="contact-phone">Телефон</label>
                                    <input type="text" name="phone" id="contact-phone"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           value="{{ old('phone') }}">
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="contact-message">Сообщение *</label>
                                    <textarea name="message" id="contact-message" rows="4"
                                              class="form-control @error('message') is-invalid @enderror"
                                              required>{{ old('message') }}</textarea>
                                    @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary btn-block">
                                    Отправить
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('pageScript')
    @parent
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    <script>
        (function () {
            var ymapsInterval = setInterval(function () {
                if (window.ymaps && typeof ymaps.ready === 'function') {
                    clearInterval(ymapsInterval);
                    ymaps.ready(initContactMap);
                }
            }, 200);

            function initContactMap() {
                var coords = [55.8016, 37.4783]; // Паршина 10, Москва
                var map = new ymaps.Map('contact-map', {
                    center: coords,
                    zoom: 16,
                    controls: ['zoomControl', 'fullscreenControl']
                });
                map.behaviors.disable('scrollZoom');

                var placemark = new ymaps.Placemark(coords, {
                    balloonContent: 'Паршина 10, Москва',
                    hintContent: 'Паршина 10, Москва'
                }, {
                    preset: 'islands#redDotIcon'
                });

                map.geoObjects.add(placemark);
            }
        })();

        (function () {
            var form = document.getElementById('contact-form');
            if (!form) return;
            var submitButton = form.querySelector('button[type="submit"]');
            var tokenInput = document.getElementById('recaptcha-token');
            var siteKey = "{{ config('services.recaptcha.site_key') }}";

            form.addEventListener('submit', function (e) {
                if (!siteKey) {
                    return; // контроллер всё равно вернёт ошибку
                }
                e.preventDefault();
                if (submitButton) submitButton.disabled = true;

                grecaptcha.ready(function () {
                    grecaptcha.execute(siteKey, {action: 'contact'}).then(function (token) {
                        if (tokenInput) tokenInput.value = token;
                        form.submit();
                    }).catch(function () {
                        if (submitButton) submitButton.disabled = false;
                        alert('Не удалось проверить reCAPTCHA. Попробуйте ещё раз.');
                    });
                });
            });
        })();
    </script>
@endsection

