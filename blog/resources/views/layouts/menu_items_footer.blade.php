<h5>Навигация</h5>
@switch($active_menu_item)
    @case('Обо мне')

    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="#" class="nav-link active">Обо мне</a>
        </li>
        <li class="nav-item">
            <a href="{{route('blog.blog')}}" class="nav-link">Блог</a>
        </li>
        <li class="nav-item">
            <a href="{{route('docs.terms_of_use')}}" class="nav-link">Правила</a>
        </li>
        @guest
            {{--                <li class="nav-item">--}}
            {{--                    <a href="/redirect-default" class="nav-link">Авторизоваться через Facebook</a>--}}
            {{--                </li>--}}
            <li class="nav-item">
{{--                <a href="/redirect-vk" class="nav-link">Авторизоваться через VK</a>--}}
                <div>
                    <script src="https://unpkg.com/@vkid/sdk@<3.0.0/dist-sdk/umd/index.js"></script>
                    <script type="text/javascript">
                        if ('VKIDSDK' in window) {
                            const VKID = window.VKIDSDK;

                            VKID.Config.init({
                                app: 53261431,
                                redirectUrl: 'https://ampleev.com/redirect-vk',
                                responseMode: VKID.ConfigResponseMode.Callback,
                                source: VKID.ConfigSource.LOWCODE,
                                scope: '', // Заполните нужными доступами по необходимости
                            });

                            const oneTap = new VKID.OneTap();

                            oneTap.render({
                                container: document.currentScript.parentElement,
                                showAlternativeLogin: true,
                                styles: {
                                    height: 38
                                },
                                oauthList: [
                                    'ok_ru',
                                    'mail_ru'
                                ]
                            })
                                .on(VKID.WidgetEvents.ERROR, vkidOnError)
                                .on(VKID.OneTapInternalEvents.LOGIN_SUCCESS, function (payload) {
                                    const code = payload.code;
                                    const deviceId = payload.device_id;

                                    VKID.Auth.exchangeCode(code, deviceId)
                                        .then(vkidOnSuccess)
                                        .catch(vkidOnError);
                                });

                            function vkidOnSuccess(data) {
                                // Обработка полученного результата
                            }

                            function vkidOnError(error) {
                                // Обработка ошибки
                            }
                        }
                    </script>
                </div>
            </li>
        @endguest
        @auth
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/logout') }}" onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">Выйти</a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                      style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        @endauth
    </ul>

    @break
    @case('Блог')
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{route('static_pages.about_me')}}" class="nav-link">Обо мне</a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link active">Блог</a>
        </li>
        <li class="nav-item">
            <a href="{{route('docs.terms_of_use')}}" class="nav-link">Правила</a>
        </li>
        @guest
            {{--                <li class="nav-item">--}}
            {{--                    <a href="/redirect-default" class="nav-link">Авторизоваться через Facebook</a>--}}
            {{--                </li>--}}
            <li class="nav-item">
{{--                <a href="/redirect-vk" class="nav-link">Авторизоваться через VK</a>--}}
                <div>
                    <script src="https://unpkg.com/@vkid/sdk@<3.0.0/dist-sdk/umd/index.js"></script>
                    <script type="text/javascript">
                        if ('VKIDSDK' in window) {
                            const VKID = window.VKIDSDK;

                            VKID.Config.init({
                                app: 53261431,
                                redirectUrl: 'https://ampleev.com/redirect-vk',
                                responseMode: VKID.ConfigResponseMode.Callback,
                                source: VKID.ConfigSource.LOWCODE,
                                scope: '', // Заполните нужными доступами по необходимости
                            });

                            const oneTap = new VKID.OneTap();

                            oneTap.render({
                                container: document.currentScript.parentElement,
                                showAlternativeLogin: true,
                                styles: {
                                    height: 38
                                },
                                oauthList: [
                                    'ok_ru',
                                    'mail_ru'
                                ]
                            })
                                .on(VKID.WidgetEvents.ERROR, vkidOnError)
                                .on(VKID.OneTapInternalEvents.LOGIN_SUCCESS, function (payload) {
                                    const code = payload.code;
                                    const deviceId = payload.device_id;

                                    VKID.Auth.exchangeCode(code, deviceId)
                                        .then(vkidOnSuccess)
                                        .catch(vkidOnError);
                                });

                            function vkidOnSuccess(data) {
                                // Обработка полученного результата
                            }

                            function vkidOnError(error) {
                                // Обработка ошибки
                            }
                        }
                    </script>
                </div>
            </li>
        @endguest
        @auth
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/logout') }}" onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">Выйти</a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                      style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        @endauth
    </ul>
    @break

    @case('Блог_статья')
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{route('static_pages.about_me')}}" class="nav-link">Обо мне</a>
        </li>
        <li class="nav-item">
            <a href="{{route('blog.blog')}}" class="nav-link active">Блог</a>
        </li>
        <li class="nav-item">
            <a href="{{route('docs.terms_of_use')}}" class="nav-link">Правила</a>
        </li>
        @guest
            {{--                <li class="nav-item">--}}
            {{--                    <a href="/redirect-default" class="nav-link">Авторизоваться через Facebook</a>--}}
            {{--                </li>--}}
            <li class="nav-item">
{{--                <a href="/redirect-vk" class="nav-link">Авторизоваться через VK</a>--}}
                <div>
                    <script src="https://unpkg.com/@vkid/sdk@<3.0.0/dist-sdk/umd/index.js"></script>
                    <script type="text/javascript">
                        if ('VKIDSDK' in window) {
                            const VKID = window.VKIDSDK;

                            VKID.Config.init({
                                app: 53261431,
                                redirectUrl: 'https://ampleev.com/redirect-vk',
                                responseMode: VKID.ConfigResponseMode.Callback,
                                source: VKID.ConfigSource.LOWCODE,
                                scope: '', // Заполните нужными доступами по необходимости
                            });

                            const oneTap = new VKID.OneTap();

                            oneTap.render({
                                container: document.currentScript.parentElement,
                                showAlternativeLogin: true,
                                styles: {
                                    height: 38
                                },
                                oauthList: [
                                    'ok_ru',
                                    'mail_ru'
                                ]
                            })
                                .on(VKID.WidgetEvents.ERROR, vkidOnError)
                                .on(VKID.OneTapInternalEvents.LOGIN_SUCCESS, function (payload) {
                                    const code = payload.code;
                                    const deviceId = payload.device_id;

                                    VKID.Auth.exchangeCode(code, deviceId)
                                        .then(vkidOnSuccess)
                                        .catch(vkidOnError);
                                });

                            function vkidOnSuccess(data) {
                                // Обработка полученного результата
                            }

                            function vkidOnError(error) {
                                // Обработка ошибки
                            }
                        }
                    </script>
                </div>
            </li>
        @endguest
        @auth
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/logout') }}" onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">Выйти</a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                      style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        @endauth
    </ul>
    @break

    @case('Правила')
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{route('static_pages.about_me')}}" class="nav-link">Обо мне</a>
        </li>
        <li class="nav-item">
            <a href="{{route('blog.blog')}}" class="nav-link">Блог</a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link active">Правила</a>
        </li>
        @guest
            {{--                <li class="nav-item">--}}
            {{--                    <a href="/redirect-default" class="nav-link">Авторизоваться через Facebook</a>--}}
            {{--                </li>--}}
            <li class="nav-item">
{{--                <a href="/redirect-vk" class="nav-link">Авторизоваться через VK</a>--}}
                <div>
                    <script src="https://unpkg.com/@vkid/sdk@<3.0.0/dist-sdk/umd/index.js"></script>
                    <script type="text/javascript">
                        if ('VKIDSDK' in window) {
                            const VKID = window.VKIDSDK;

                            VKID.Config.init({
                                app: 53261431,
                                redirectUrl: 'https://ampleev.com/redirect-vk',
                                responseMode: VKID.ConfigResponseMode.Callback,
                                source: VKID.ConfigSource.LOWCODE,
                                scope: '', // Заполните нужными доступами по необходимости
                            });

                            const oneTap = new VKID.OneTap();

                            oneTap.render({
                                container: document.currentScript.parentElement,
                                showAlternativeLogin: true,
                                styles: {
                                    height: 38
                                },
                                oauthList: [
                                    'ok_ru',
                                    'mail_ru'
                                ]
                            })
                                .on(VKID.WidgetEvents.ERROR, vkidOnError)
                                .on(VKID.OneTapInternalEvents.LOGIN_SUCCESS, function (payload) {
                                    const code = payload.code;
                                    const deviceId = payload.device_id;

                                    VKID.Auth.exchangeCode(code, deviceId)
                                        .then(vkidOnSuccess)
                                        .catch(vkidOnError);
                                });

                            function vkidOnSuccess(data) {
                                // Обработка полученного результата
                            }

                            function vkidOnError(error) {
                                // Обработка ошибки
                            }
                        }
                    </script>
                </div>
            </li>
        @endguest
        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/logout') }}" onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">Выйти</a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
        @endauth
    </ul>
    @break

    @default
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{route('static_pages.about_me')}}" class="nav-link">Обо мне</a>
        </li>
        <li class="nav-item">
            <a href="{{route('blog.blog')}}" class="nav-link">Блог</a>
        </li>
        <li class="nav-item">
            <a href="{{route('docs.terms_of_use')}}" class="nav-link">Правила</a>
        </li>
        @guest
            {{--                <li class="nav-item">--}}
            {{--                    <a href="/redirect-default" class="nav-link">Авторизоваться через Facebook</a>--}}
            {{--                </li>--}}
            <li class="nav-item">
{{--                <a href="/redirect-vk" class="nav-link">Авторизоваться через VK</a>--}}
                <div>
                    <script src="https://unpkg.com/@vkid/sdk@<3.0.0/dist-sdk/umd/index.js"></script>
                    <script type="text/javascript">
                        if ('VKIDSDK' in window) {
                            const VKID = window.VKIDSDK;

                            VKID.Config.init({
                                app: 53261431,
                                redirectUrl: 'https://ampleev.com/redirect-vk',
                                responseMode: VKID.ConfigResponseMode.Callback,
                                source: VKID.ConfigSource.LOWCODE,
                                scope: '', // Заполните нужными доступами по необходимости
                            });

                            const oneTap = new VKID.OneTap();

                            oneTap.render({
                                container: document.currentScript.parentElement,
                                showAlternativeLogin: true,
                                styles: {
                                    height: 38
                                },
                                oauthList: [
                                    'ok_ru',
                                    'mail_ru'
                                ]
                            })
                                .on(VKID.WidgetEvents.ERROR, vkidOnError)
                                .on(VKID.OneTapInternalEvents.LOGIN_SUCCESS, function (payload) {
                                    const code = payload.code;
                                    const deviceId = payload.device_id;

                                    VKID.Auth.exchangeCode(code, deviceId)
                                        .then(vkidOnSuccess)
                                        .catch(vkidOnError);
                                });

                            function vkidOnSuccess(data) {
                                // Обработка полученного результата
                            }

                            function vkidOnError(error) {
                                // Обработка ошибки
                            }
                        }
                    </script>
                </div>
            </li>
        @endguest
        @auth
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/logout') }}" onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">Выйти</a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                      style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        @endauth
    </ul>
@endswitch
