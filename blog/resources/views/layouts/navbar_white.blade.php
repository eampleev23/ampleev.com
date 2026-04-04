@php
    use App\Support\SiteLocale;

    $homeRoute = SiteLocale::routeNameForLocale('static_pages.home', $site_locale ?? 'ru');
    $ruSwitchLabel = ($site_locale ?? 'ru') === 'ru' ? 'РУС' : 'RU';
    $enSwitchLabel = ($site_locale ?? 'ru') === 'ru' ? 'АНГ' : 'EN';
@endphp

<div class="navbar-container ">
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">

            <a class="navbar-brand fade-page" href="{{ route($homeRoute) }}">
                <span>Ampleev.com</span>
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse"
                    aria-expanded="false" aria-label="Toggle navigation">
                <img class="icon navbar-toggler-open" src="/assets/img/icons/interface/menu.svg"
                     alt="menu interface icon" data-inject-svg/>
                <img class="icon navbar-toggler-close" src="/assets/img/icons/interface/cross.svg"
                     alt="cross interface icon" data-inject-svg/>
            </button>
            <div class="collapse navbar-collapse justify-content-end">
                <div class="py-2 py-lg-0">
                    @include('layouts.menu_items', ['active_menu_item' => $active_menu_item ?? ''])
                </div>

                <div class="m-1 ml-lg-4 pl-lg-2 d-flex align-items-center">
                    <div class="mr-3 d-flex align-items-center text-uppercase small">
                        <a href="{{ $locale_switch_urls['ru'] }}"
                           class="nav-link px-1 text-dark {{ $site_locale === 'ru' ? 'font-weight-bold' : 'opacity-50' }}"
                           rel="alternate"
                           hreflang="ru">{{ $ruSwitchLabel }}</a>
                        <span class="text-muted">|</span>
                        <a href="{{ $locale_switch_urls['en'] }}"
                           class="nav-link px-1 text-dark {{ $site_locale === 'en' ? 'font-weight-bold' : 'opacity-50' }}"
                           rel="alternate"
                           hreflang="en">{{ $enSwitchLabel }}</a>
                    </div>

                    @auth
                        <div class="dropdown ml-2">
                            <img src="{{Auth::user()->avatar_path}}" alt="User"
                                 class="avatar avatar-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                 aria-expanded="false">
                            <div class="dropdown-menu dropdown-menu-right dropdown-content">
                                <a class="dropdown-item" href="{{ route('user.profile') }}">{{ $locale_labels['my_profile'] ?? 'Мой профиль' }}</a>
                                <a class="dropdown-item" href="{{ url('/logout') }}" onclick="event.preventDefault();
                                                                             document.getElementById('logout-form').submit();">{{ $locale_labels['logout'] ?? 'Выйти' }}</a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>
                    @endauth

                    @guest
                        {{--                        <a href="{{env('APP_URL').'/redirect-default'}}" class="btn btn-primary">Войти через--}}
                        {{--                            Facebook</a>--}}
{{--                        <a href="{{env('APP_URL').'/redirect-vk'}}" class="btn btn-primary">Войти через--}}
{{--                            VK ID</a>--}}
                    @endguest

                </div>


            </div>
    </nav>
</div>
