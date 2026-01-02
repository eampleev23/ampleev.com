@extends('layouts.app')

@section('title', 'Связаться')
@section('description', 'Свяжитесь со мной по любым вопросам: email, телефон или форма обратной связи.')
@section('page_url', route('static_pages.contact'))

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
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-8 col-xl-6">
                    <div class="text-center mb-4">
                        <h2 class="h1">Оставить сообщение</h2>
                        <p class="lead">Есть вопрос или идея для сотрудничества? Оставьте сообщение, и мы ответим.</p>
                    </div>
                    <form id="contact-form" method="POST" action="{{ route('static_pages.contact_submit') }}" novalidate>
                        @csrf
                        <input type="text" name="contact_trap" class="d-none" tabindex="-1" autocomplete="off">
                        <input type="hidden" name="recaptcha_token" id="recaptcha-token">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ваше имя *</label>
                                    <input name="name" type="text" class="form-control" value="{{ old('name') }}" required>
                                    <div class="invalid-feedback">
                                        Пожалуйста, введите ваше имя.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email *</label>
                                    <input name="email" type="email" class="form-control" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Компания</label>
                                    <input name="company" type="text" class="form-control" value="{{ old('company') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Телефон</label>
                                    <input name="phone" type="tel" class="form-control" value="{{ old('phone') }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Сообщение:</label>
                                    <textarea class="form-control" name="message" rows="10" required>{{ old('message') }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-none alert alert-success" role="alert" data-success-message>
                                    Спасибо! Мы свяжемся с вами в ближайшее время.
                                </div>
                                <div class="d-none alert alert-danger" role="alert" data-error-message>
                                    Пожалуйста, заполните все поля правильно.
                                </div>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-loading" data-loading-text="Отправка">
                                    <img class="icon" src="/assets/img/icons/theme/code/loading.svg" alt="loading icon" data-inject-svg/>
                                    <span>Отправить</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('pageScript')
    @parent
    @if(config('services.recaptcha.site_key'))
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}" async defer></script>
    @endif
    <script>
        (function () {
            var form = document.getElementById('contact-form');
            if (!form) return;
            var submitButton = form.querySelector('button[type="submit"]');
            var tokenInput = document.getElementById('recaptcha-token');
            var siteKey = "{{ config('services.recaptcha.site_key') }}";
            var successMessage = form.querySelector('[data-success-message]');
            var errorMessage = form.querySelector('[data-error-message]');

            @if(session('contact_success'))
                if (successMessage) {
                    successMessage.classList.remove('d-none');
                    form.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            @endif

            @if($errors->has('form'))
                if (errorMessage) {
                    errorMessage.textContent = '{{ $errors->first('form') }}';
                    errorMessage.classList.remove('d-none');
                    form.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            @endif

            form.addEventListener('submit', function (e) {
                if (!siteKey) {
                    return;
                }
                e.preventDefault();
                if (submitButton) {
                    submitButton.classList.add('loading');
                    submitButton.disabled = true;
                }

                grecaptcha.ready(function () {
                    grecaptcha.execute(siteKey, {action: 'contact'}).then(function (token) {
                        if (tokenInput) tokenInput.value = token;
                        // Debug: проверка работы reCAPTCHA (можно удалить после проверки)
                        console.log('reCAPTCHA v3 token получен:', token ? token.substring(0, 20) + '...' : 'нет токена');
                        form.submit();
                    }).catch(function (error) {
                        console.error('reCAPTCHA v3 ошибка:', error);
                        if (submitButton) {
                            submitButton.classList.remove('loading');
                            submitButton.disabled = false;
                        }
                        if (errorMessage) {
                            errorMessage.textContent = 'Не удалось проверить reCAPTCHA. Попробуйте ещё раз.';
                            errorMessage.classList.remove('d-none');
                        }
                    });
                });
            });
        })();
    </script>
@endsection
