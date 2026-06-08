@php
    use App\Support\SiteLocale;

    $currentLocale = $site_locale ?? 'ru';
    $contactRoute = SiteLocale::routeNameForLocale('static_pages.contact', $currentLocale);
    $contactSubmitRoute = SiteLocale::routeNameForLocale('static_pages.contact_submit', $currentLocale);
    $contactRuUrl = route('static_pages.contact');
    $contactEnUrl = route('en.static_pages.contact');
    $locale_switch_urls = [
        'ru' => $contactRuUrl,
        'en' => $contactEnUrl,
    ];
    $copy = $currentLocale === 'en'
        ? [
            'title' => 'Contact',
            'description' => 'Get in touch for collaboration, product, delivery, and Agile-related questions.',
            'heading' => 'Send a message',
            'lead' => 'Have a question or an idea for collaboration? Leave a message and we will get back to you.',
            'name' => 'Your name *',
            'name_error' => 'Please enter your name.',
            'email' => 'Email *',
            'company' => 'Company',
            'phone' => 'Phone',
            'message' => 'Message',
            'success' => 'Thank you! We will get back to you soon.',
            'error' => 'Please fill in all fields correctly.',
            'submit' => 'Send',
            'loading' => 'Sending',
            'recaptcha_error' => 'Could not verify reCAPTCHA. Please try again.',
        ]
        : [
            'title' => 'Контакты',
            'description' => 'Свяжитесь со мной по любым вопросам: email, телефон или форма обратной связи.',
            'heading' => 'Оставить сообщение',
            'lead' => 'Есть вопрос или идея для сотрудничества? Оставьте сообщение, и мы ответим.',
            'name' => 'Ваше имя *',
            'name_error' => 'Пожалуйста, введите ваше имя.',
            'email' => 'Email *',
            'company' => 'Компания',
            'phone' => 'Телефон',
            'message' => 'Сообщение:',
            'success' => 'Спасибо! Мы свяжемся с вами в ближайшее время.',
            'error' => 'Пожалуйста, заполните все поля правильно.',
            'submit' => 'Отправить',
            'loading' => 'Отправка',
            'recaptcha_error' => 'Не удалось проверить reCAPTCHA. Попробуйте ещё раз.',
        ];
@endphp

@extends('layouts.app')

@section('title', $copy['title'])
@section('description', $copy['description'])
@section('page_url', route($contactRoute))
@section('canonical_url', route($contactRoute))
@section('alternate_url_ru', $contactRuUrl)
@section('alternate_url_en', $contactEnUrl)
@section('x_default_url', $contactEnUrl)

@section('custom_css')
    @parent
    <link href="{{ asset('assets/css/custom.css') }}?v={{ filemtime(public_path('assets/css/custom.css')) }}" rel="stylesheet"
          type="text/css" media="all"/>
@endsection

@section('sidebar')
    @parent
@endsection

@section('content')
    @include('layouts.navbar_white')
    <section class="contact-page-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-8 col-xl-6">
                    <div class="text-center mb-4">
                        <h2 class="h1">{{ $copy['heading'] }}</h2>
                        <p class="lead">{{ $copy['lead'] }}</p>
                    </div>
                    <form id="contact-form" class="contact-form-card" method="POST" action="{{ route($contactSubmitRoute) }}" novalidate>
                        @csrf
                        <input type="text" name="contact_trap" class="d-none" tabindex="-1" autocomplete="off">
                        <input type="hidden" name="recaptcha_token" id="recaptcha-token">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $copy['name'] }}</label>
                                    <input name="name" type="text" class="form-control" value="{{ old('name') }}" required>
                                    <div class="invalid-feedback">
                                        {{ $copy['name_error'] }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $copy['email'] }}</label>
                                    <input name="email" type="email" class="form-control" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $copy['company'] }}</label>
                                    <input name="company" type="text" class="form-control" value="{{ old('company') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $copy['phone'] }}</label>
                                    <input name="phone" type="tel" class="form-control" value="{{ old('phone') }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ $copy['message'] }}</label>
                                    <textarea class="form-control" name="message" rows="10" required>{{ old('message') }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-none alert alert-success" role="alert" data-success-message>
                                    {{ $copy['success'] }}
                                </div>
                                <div class="d-none alert alert-danger" role="alert" data-error-message>
                                    {{ $copy['error'] }}
                                </div>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-loading" data-loading-text="{{ $copy['loading'] }}">
                                    <img class="icon" src="/assets/img/icons/theme/code/loading.svg" alt="loading icon" data-inject-svg/>
                                    <span>{{ $copy['submit'] }}</span>
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
                            errorMessage.textContent = @json($copy['recaptcha_error']);
                            errorMessage.classList.remove('d-none');
                        }
                    });
                });
            });
        })();
    </script>
@endsection
