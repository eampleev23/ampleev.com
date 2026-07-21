@extends('layouts.app')

@section('title', $copy['title'])
@section('description', $copy['description'])
@section('meta_robots', 'noindex, nofollow')

@php
    use App\Support\SiteLocale;
    $canonicalRoute = SiteLocale::routeNameForLocale('static_pages.yai', $currentLocale);
@endphp
@section('canonical_url', route($canonicalRoute))
@section('alternate_url_ru', route('static_pages.yai'))
@section('alternate_url_en', route('en.static_pages.yai'))

@section('custom_css')
    <style>
        .yai-chat-card {
            max-width: 760px;
            margin: 0 auto;
        }
        .yai-messages {
            min-height: 320px;
            max-height: 60vh;
            overflow-y: auto;
            padding: 4px;
        }
        .yai-msg {
            display: flex;
            margin-bottom: 12px;
        }
        .yai-msg--user {
            justify-content: flex-end;
        }
        .yai-bubble {
            max-width: 85%;
            padding: 12px 16px;
            border-radius: 14px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .yai-msg--user .yai-bubble {
            background: #0071ff;
            color: #fff;
            border-bottom-right-radius: 4px;
        }
        .yai-msg--bot .yai-bubble {
            background: rgba(0, 113, 255, 0.06);
            border: 1px solid rgba(0, 113, 255, 0.12);
            border-bottom-left-radius: 4px;
        }
        .yai-sources {
            margin-top: 8px;
            font-size: 0.8125rem;
        }
        .yai-sources a {
            display: inline-block;
            margin: 2px 6px 2px 0;
            padding: 2px 10px;
            border: 1px solid rgba(0, 113, 255, 0.25);
            border-radius: 999px;
            text-decoration: none;
        }
        .yai-typing .yai-bubble {
            color: #6c757d;
        }
        .yai-typing .yai-bubble span {
            animation: yai-blink 1.2s infinite;
        }
        .yai-typing .yai-bubble span:nth-child(2) { animation-delay: .2s; }
        .yai-typing .yai-bubble span:nth-child(3) { animation-delay: .4s; }
        @keyframes yai-blink {
            0%, 80%, 100% { opacity: .2; }
            40% { opacity: 1; }
        }
        .yai-disclaimer {
            font-size: 0.8125rem;
        }
    </style>
@endsection

@section('content')
    @include('layouts.navbar_white')

    <section class="pt-5 pb-2">
        <div class="container">
            <div class="yai-chat-card text-center">
                <h1 class="mb-2">{{ $copy['heading'] }}</h1>
                <p class="lead text-muted mb-4">{{ $copy['subheading'] }}</p>
            </div>
        </div>
    </section>

    <section class="pb-5">
        <div class="container">
            <div class="yai-chat-card card card-body shadow-sm">
                <div class="yai-messages" id="yai-messages" aria-live="polite"></div>
                <form id="yai-form" class="mt-3" autocomplete="off">
                    <div class="form-row">
                        <div class="col">
                            <input type="text"
                                   id="yai-input"
                                   class="form-control"
                                   maxlength="1200"
                                   placeholder="{{ $copy['placeholder'] }}"
                                   required>
                        </div>
                        <div class="col-auto">
                            <button type="submit" id="yai-send" class="btn btn-primary">{{ $copy['send'] }}</button>
                        </div>
                    </div>
                </form>
                <p class="yai-disclaimer text-muted mt-3 mb-0">{{ $copy['disclaimer'] }}</p>
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
                error: @json($copy['error'])
            };

            var messagesEl = document.getElementById('yai-messages');
            var formEl = document.getElementById('yai-form');
            var inputEl = document.getElementById('yai-input');
            var sendEl = document.getElementById('yai-send');
            var history = [];

            function appendMessage(role, text, sources) {
                var wrap = document.createElement('div');
                wrap.className = 'yai-msg yai-msg--' + (role === 'user' ? 'user' : 'bot');

                var bubble = document.createElement('div');
                bubble.className = 'yai-bubble';
                bubble.textContent = text;

                if (sources && sources.length) {
                    var sourcesEl = document.createElement('div');
                    sourcesEl.className = 'yai-sources';
                    var label = document.createElement('span');
                    label.className = 'text-muted';
                    label.textContent = labels.sources + ': ';
                    sourcesEl.appendChild(label);
                    sources.forEach(function (source) {
                        var link = document.createElement('a');
                        link.href = source.url;
                        link.target = '_blank';
                        link.rel = 'noopener';
                        link.textContent = source.title;
                        sourcesEl.appendChild(link);
                    });
                    bubble.appendChild(sourcesEl);
                }

                wrap.appendChild(bubble);
                messagesEl.appendChild(wrap);
                messagesEl.scrollTop = messagesEl.scrollHeight;
                return wrap;
            }

            function appendTyping() {
                var wrap = document.createElement('div');
                wrap.className = 'yai-msg yai-msg--bot yai-typing';
                wrap.innerHTML = '<div class="yai-bubble"><span>●</span> <span>●</span> <span>●</span></div>';
                messagesEl.appendChild(wrap);
                messagesEl.scrollTop = messagesEl.scrollHeight;
                return wrap;
            }

            function setBusy(busy) {
                inputEl.disabled = busy;
                sendEl.disabled = busy;
                if (!busy) {
                    inputEl.focus();
                }
            }

            appendMessage('assistant', labels.greeting);

            formEl.addEventListener('submit', function (event) {
                event.preventDefault();
                var message = inputEl.value.trim();
                if (!message) {
                    return;
                }

                appendMessage('user', message);
                inputEl.value = '';
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
                    appendMessage('assistant', data.answer, data.sources);
                    history.push({ role: 'user', content: message });
                    history.push({ role: 'assistant', content: data.answer });
                }).catch(function () {
                    typingEl.remove();
                    appendMessage('assistant', labels.error);
                }).finally(function () {
                    setBusy(false);
                });
            });
        })();
    </script>
@endsection
