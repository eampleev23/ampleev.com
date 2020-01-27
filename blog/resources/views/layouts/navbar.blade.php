<div class="navbar-container ">
    <nav class="navbar navbar-expand-lg navbar-dark" data-overlay>
        <div class="container">
            <a class="navbar-brand fade-page" href="/">
                <span>Ampleev.com</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse"
                    aria-expanded="false" aria-label="Toggle navigation">
                <img class="icon navbar-toggler-open" src="assets/img/icons/interface/menu.svg"
                     alt="menu interface icon" data-inject-svg/>
                <img class="icon navbar-toggler-close" src="assets/img/icons/interface/cross.svg"
                     alt="cross interface icon" data-inject-svg/>
            </button>
            <div class="collapse navbar-collapse justify-content-end">
                <div class="py-2 py-lg-0">

                    @include('layouts.menu_items')

                </div>

                <div class="m-1">

                    @auth
                        <div class="dropdown ml-2">
                            <img src="{{Auth::user()->avatar_path}}" alt="User"
                                 class="avatar avatar-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                 aria-expanded="false">
                            <div class="dropdown-menu dropdown-menu-right dropdown-content">
                                <h6 id="menu_active_item">Мой профиль</h6>
                                <a class="dropdown-item" href="{{ url('/logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Выйти</a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>
                    @endauth

                    @guest
                        <a href="{{env('APP_URL').'/redirect-default'}}" class="btn btn-primary">Войти через
                            Facebook</a>
                    @endguest

                </div>

                {{--                <a href="#" class="btn btn-primary ml-lg-3">Вход / Регистрация</a>--}}

            </div>
        </div>
    </nav>
</div>