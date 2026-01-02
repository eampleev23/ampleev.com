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
    <style>
        .contact-form-section {
            padding-top: 80px;
            padding-bottom: 80px;
        }
        .contact-form-section .form-group label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #212529;
        }
        .contact-form-section .form-control {
            border-radius: 0;
            border: 1px solid rgba(0,0,0,0.1);
            padding: 12px 16px;
        }
        .contact-form-section .btn-primary {
            border-radius: 0;
            padding: 12px 24px;
            font-weight: 600;
        }
        .contact-success-message {
            display: none;
            padding: 16px;
            background: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            color: #155724;
            margin-bottom: 20px;
        }
        .contact-error-message {
            display: none;
            padding: 16px;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            color: #721c24;
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('content')
    @include('layouts.navbar_white')
    <section class="has-divider text-light jarallax bg-dark" data-jarallax data-speed="0.5" data-overlay>
    </section>

    <section class="contact-form-section">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-5">
                    <div class="card shadow">
                        <div class="card-body p-4">
                            <h3 class="mb-3">Оставить сообщение</h3>
                            <p class="text-muted mb-4">Заполните поля, отмеченные звёздочкой. Остальные — по желанию.</p>

                            <div id="contact-success-message" class="contact-success-message">
                                Спасибо! Мы свяжемся с вами в ближайшее время.
                            </div>
                            <div id="contact-error-message" class="contact-error-message"></div>

                            <form id="contact-form" method="POST" action="{{ route('static_pages.contact_submit') }}" novalidate>
                                @csrf
                                <input type="text" name="contact_trap" class="d-none" tabindex="-1" autocomplete="off">
                                <input type="hidden" name="recaptcha_token" id="recaptcha-token">

                                <div class="form-group">
                                    <label for="contact-name">Ваше имя *</label>
                                    <input type="text" name="name" id="contact-name"
                                           class="form-control"
                                           value="{{ old('name') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="contact-email">Email *</label>
                                    <input type="email" name="email" id="contact-email"
                                           class="form-control"
                                           value="{{ old('email') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="contact-company">Компания</label>
                                    <input type="text" name="company" id="contact-company"
                                           class="form-control"
                                           value="{{ old('company') }}">
                                </div>

                                <div class="form-group">
                                    <label for="contact-phone">Телефон</label>
                                    <input type="text" name="phone" id="contact-phone"
                                           class="form-control"
                                           value="{{ old('phone') }}">
                                </div>

                                <div class="form-group">
                                    <label for="contact-message">Сообщение *</label>
                                    <textarea name="message" id="contact-message" rows="4"
                                              class="form-control"
                                              required>{{ old('message') }}</textarea>
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
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    <script>
        (function () {
            var form = document.getElementById('contact-form');
            if (!form) return;
            var submitButton = form.querySelector('button[type="submit"]');
            var tokenInput = document.getElementById('recaptcha-token');
            var siteKey = "{{ config('services.recaptcha.site_key') }}";
            var successMessage = document.getElementById('contact-success-message');
            var errorMessage = document.getElementById('contact-error-message');

            @if(session('contact_success'))
                if (successMessage) {
                    successMessage.style.display = 'block';
                    form.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            @endif

            @if($errors->has('form'))
                if (errorMessage) {
                    errorMessage.textContent = '{{ $errors->first('form') }}';
                    errorMessage.style.display = 'block';
                    form.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            @endif

            form.addEventListener('submit', function (e) {
                if (!siteKey) {
                    return;
                }
                e.preventDefault();
                if (submitButton) submitButton.disabled = true;

                grecaptcha.ready(function () {
                    grecaptcha.execute(siteKey, {action: 'contact'}).then(function (token) {
                        if (tokenInput) tokenInput.value = token;
                        form.submit();
                    }).catch(function () {
                        if (submitButton) submitButton.disabled = false;
                        if (errorMessage) {
                            errorMessage.textContent = 'Не удалось проверить reCAPTCHA. Попробуйте ещё раз.';
                            errorMessage.style.display = 'block';
                        }
                    });
                });
            });
        })();
    </script>
@endsection
