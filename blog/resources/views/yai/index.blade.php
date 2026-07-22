@extends('layouts.app')

@section('title', $copy['title'])
@section('description', $copy['description'])

@php
    use App\Support\SiteLocale;
    $canonicalRoute = SiteLocale::routeNameForLocale('static_pages.yai', $currentLocale);
    $contactRoute = SiteLocale::routeNameForLocale('static_pages.contact', $currentLocale);
@endphp
@section('canonical_url', route($canonicalRoute))
@section('alternate_url_ru', route('static_pages.yai'))
@section('alternate_url_en', route('en.static_pages.yai'))

@section('custom_css')
    <link href="{{ asset('assets/css/custom.css') }}?v={{ filemtime(public_path('assets/css/custom.css')) }}" rel="stylesheet" type="text/css" media="all"/>
@endsection

@section('content')
    @include('layouts.navbar_white')

    <section class="aiya-page">
        <div class="container">
            <div class="aiya-layout">
                {{-- Шапка над чатом: заголовок слева, пояснение и темы справа --}}
                <header class="aiya-intro">
                    <div class="aiya-intro__main">
                        <div class="aiya-intro__eyebrow" data-aos="fade-up">{{ $copy['eyebrow'] }}</div>
                        <h1 class="aiya-intro__title" translate="no" data-aos="fade-up" data-aos-delay="100">{{ $copy['heading'] }}</h1>
                    </div>
                    <div class="aiya-intro__aside" data-aos="fade-up" data-aos-delay="150">
                        <p class="aiya-intro__lead">{{ $copy['subheading'] }}</p>
                        <div class="aiya-intro__topics">
                            @foreach($copy['topics'] as $topic)
                                <span class="aiya-topic">{{ $topic }}</span>
                            @endforeach
                        </div>
                    </div>
                </header>

                {{-- Чат интерактивен сразу: без AOS-задержек на основном элементе страницы --}}
                <div class="aiya-chat-col">
                    <div class="aiya-chat" id="aiya-chat">
                        <div class="aiya-chat__messages" id="aiya-messages" role="log" aria-live="polite"></div>

                        <form id="aiya-form" class="aiya-chat__composer" autocomplete="off">
                            <label for="aiya-input" class="sr-only">{{ $copy['input_label'] }}</label>
                            <textarea id="aiya-input"
                                      name="message"
                                      class="aiya-chat__input"
                                      rows="1"
                                      maxlength="1200"
                                      placeholder="{{ $copy['placeholder'] }}"
                                      required></textarea>
                            <button type="submit" id="aiya-send" class="btn btn-primary aiya-chat__send">
                                <span id="aiya-send-label">{{ $copy['send'] }}</span>
                            </button>
                        </form>

                        <p class="aiya-chat__disclaimer">{{ $copy['disclaimer_lead'] }}<a href="{{ route($contactRoute) }}">{{ $copy['disclaimer_link'] }}</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('pageScript')
    <script type="text/javascript">
        (function () {
            var endpoint = '/api/yai/chat';
            var locale = @json($currentLocale);
            var labels = {
                sources: @json($copy['sources_label']),
                greeting: @json($copy['greeting']),
                error: @json($copy['error']),
                send: @json($copy['send']),
                sending: @json($copy['sending'])
            };

            var messagesEl = document.getElementById('aiya-messages');
            var formEl = document.getElementById('aiya-form');
            var inputEl = document.getElementById('aiya-input');
            var sendEl = document.getElementById('aiya-send');
            var sendLabelEl = document.getElementById('aiya-send-label');
            var history = [];
            var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            // На узких экранах полный плейсхолдер не помещается — ставим короткий
            if (window.matchMedia('(max-width: 575.98px)').matches) {
                inputEl.placeholder = @json($copy['placeholder_short']);
            }
            // Автовозврат фокуса — только на устройствах с точным указателем:
            // на touch повторное открытие клавиатуры прячет полученный ответ
            var finePointer = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

            // Появление сообщения: прерываемый CSS-transition через снятие класса
            function reveal(el) {
                if (reducedMotion) {
                    return;
                }
                el.classList.add('is-entering');
                requestAnimationFrame(function () {
                    requestAnimationFrame(function () {
                        el.classList.remove('is-entering');
                    });
                });
            }

            function appendMessage(role, text, sources, extraClass) {
                var wrap = document.createElement('div');
                wrap.className = 'aiya-msg aiya-msg--' + (role === 'user' ? 'user' : 'bot') + (extraClass ? ' ' + extraClass : '');

                var bubble = document.createElement('div');
                bubble.className = 'aiya-bubble';
                bubble.textContent = text;

                if (sources && sources.length) {
                    var sourcesEl = document.createElement('div');
                    sourcesEl.className = 'aiya-sources';
                    var label = document.createElement('span');
                    label.className = 'aiya-sources__label';
                    label.textContent = labels.sources;
                    sourcesEl.appendChild(label);
                    sources.forEach(function (source, i) {
                        var link = document.createElement('a');
                        link.className = 'aiya-source';
                        link.href = source.url;
                        link.target = '_blank';
                        link.rel = 'noopener';
                        link.textContent = source.title;
                        if (!reducedMotion) {
                            link.style.transitionDelay = (i * 60) + 'ms';
                        }
                        sourcesEl.appendChild(link);
                    });
                    bubble.appendChild(sourcesEl);
                }

                wrap.appendChild(bubble);
                messagesEl.appendChild(wrap);
                reveal(wrap);
                return wrap;
            }

            function appendTyping() {
                var wrap = document.createElement('div');
                wrap.className = 'aiya-msg aiya-msg--bot aiya-typing';
                wrap.setAttribute('aria-hidden', 'true');
                wrap.innerHTML = '<div class="aiya-bubble">'
                    + '<span class="aiya-typing__dot"></span>'
                    + '<span class="aiya-typing__dot"></span>'
                    + '<span class="aiya-typing__dot"></span>'
                    + '</div>';
                messagesEl.appendChild(wrap);
                reveal(wrap);
                scrollToBottom();
                return wrap;
            }

            function scrollToBottom() {
                messagesEl.scrollTop = messagesEl.scrollHeight;
            }

            // Длинный ответ показываем с его начала, а не с конца
            function scrollToMessageStart(el) {
                var target = Math.max(el.offsetTop - 8, 0);
                if (reducedMotion || !messagesEl.scrollTo) {
                    messagesEl.scrollTop = target;
                } else {
                    messagesEl.scrollTo({ top: target, behavior: 'smooth' });
                }
            }

            function setBusy(busy) {
                inputEl.disabled = busy;
                sendEl.disabled = busy;
                sendEl.classList.toggle('is-loading', busy);
                sendLabelEl.textContent = busy ? labels.sending : labels.send;
                formEl.setAttribute('aria-busy', busy ? 'true' : 'false');
                if (!busy && finePointer) {
                    try {
                        inputEl.focus({ preventScroll: true });
                    } catch (e) {
                        inputEl.focus();
                    }
                }
            }

            function autoResize() {
                // Пустое поле всегда компактно: scrollHeight пустого textarea
                // учитывает многострочный placeholder на узких экранах
                if (inputEl.value === '') {
                    inputEl.style.height = '44px';
                    return;
                }
                inputEl.style.height = '44px';
                inputEl.style.height = Math.max(44, Math.min(inputEl.scrollHeight, 132)) + 'px';
            }

            function submitMessage() {
                var message = inputEl.value.trim();
                if (!message || sendEl.disabled) {
                    return;
                }

                appendMessage('user', message);
                scrollToBottom();
                inputEl.value = '';
                autoResize();
                setBusy(true);
                var typingEl = appendTyping();

                fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        message: message,
                        history: history.slice(-8),
                        locale: locale
                    })
                }).then(function (response) {
                    if (!response.ok) {
                        throw new Error('HTTP ' + response.status);
                    }
                    return response.json();
                }).then(function (data) {
                    typingEl.remove();
                    var answerEl = appendMessage('assistant', data.answer, data.sources);
                    scrollToMessageStart(answerEl);
                    history.push({ role: 'user', content: message });
                    history.push({ role: 'assistant', content: data.answer });
                }).catch(function () {
                    typingEl.remove();
                    var errorEl = appendMessage('assistant', labels.error, null, 'aiya-msg--error');
                    scrollToMessageStart(errorEl);
                }).finally(function () {
                    setBusy(false);
                });
            }

            appendMessage('assistant', labels.greeting);

            formEl.addEventListener('submit', function (event) {
                event.preventDefault();
                submitMessage();
            });

            // Enter — отправка, Shift+Enter — перенос строки.
            // Во время IME composition Enter подтверждает символ, а не отправляет.
            inputEl.addEventListener('keydown', function (event) {
                if (event.key === 'Enter' && !event.shiftKey) {
                    if (event.isComposing || event.keyCode === 229) {
                        return;
                    }
                    event.preventDefault();
                    submitMessage();
                }
            });

            inputEl.addEventListener('input', autoResize);
            autoResize();
        })();
    </script>
@endsection
