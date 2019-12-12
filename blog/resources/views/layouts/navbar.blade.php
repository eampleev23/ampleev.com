<div class="navbar-container ">
    <nav class="navbar navbar-expand-lg navbar-dark" data-overlay>
        <div class="container">
            <a class="navbar-brand fade-page" href="/">
                <span>Амплеев Евгений</span>
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
                    <ul class="navbar-nav">
                        {{--                        <li class="nav-item dropdown">--}}
                        {{--                            <a href="#" class="nav-link"--}}
                        {{--                               aria-expanded="false" aria-haspopup="true">Главная</a>--}}
                        {{--                        </li>--}}
                        {{--                        <li class="nav-item dropdown">--}}
                        {{--                            <a href="#" class="nav-link"--}}
                        {{--                               aria-expanded="false">Блог</a>--}}

                        {{--                        </li>--}}

                    </ul>
                </div>

                <div class="m-1">

                    @auth
                        <div class="dropdown ml-2">
                            <img src="{{Auth::user()->avatar_path}}" alt="User"
                                 class="avatar avatar-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                 aria-expanded="false">
                            <div class="dropdown-menu dropdown-menu-right dropdown-content">
                                <h6 id="menu_active_item">Мой профиль</h6>
                                <a class="dropdown-item" href="#">Выйти</a>
                            </div>
                        </div>
                    @endauth

                    @guest
                        <a href="https://ampleev.com/redirect" class="btn btn-primary">Login with Facebook</a>
                    @endguest


                    <div class="modal fade" id="sign-in-modal" tabindex="-1" role="dialog" style="display: none;"
                         aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" class="injected-svg icon bg-dark"
                                             data-src="assets/img/icons/interface/cross.svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <path d="M16.2426 6.34311L6.34309 16.2426C5.95257 16.6331 5.95257 17.2663 6.34309 17.6568C6.73362 18.0473 7.36678 18.0473 7.75731 17.6568L17.6568 7.75732C18.0473 7.36679 18.0473 6.73363 17.6568 6.34311C17.2663 5.95258 16.6331 5.95258 16.2426 6.34311Z"
                                                  fill="#212529"></path>
                                            <path d="M17.6568 16.2426L7.75734 6.34309C7.36681 5.95257 6.73365 5.95257 6.34313 6.34309C5.9526 6.73362 5.9526 7.36678 6.34313 7.75731L16.2426 17.6568C16.6331 18.0473 17.2663 18.0473 17.6568 17.6568C18.0474 17.2663 18.0474 16.6331 17.6568 16.2426Z"
                                                  fill="#212529"></path>
                                        </svg>
                                    </button>
                                    <div class="m-xl-4 m-3">
                                        <div class="text-center mb-4">
                                            <h4 class="h3 mb-1">Добро пожаловать!</h4>
                                            <span>Для авторизации или регистрации достаточно иметь профиль на facebook</span>
                                        </div>

                                        {{--                                        <div class="form-group">--}}
                                        {{--                                            <div class="col-md-8 col-md-offset-4">--}}
                                        {{--                                                <a href="{{url('/redirect')}}" class="btn btn-primary">Login with Facebook</a>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}

                                        <form>
                                            <div class="form-group">
                                                <input type="email" name="login-email" placeholder="Email Address"
                                                       class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="login-password" placeholder="Password"
                                                       class="form-control">
                                                <small><a href="#">Forgot your password?</a>
                                                </small>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn-block btn btn-primary" type="submit">Авторизоваться
                                                    через Facebook
                                                </button>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="login-remember">
                                                <label class="custom-control-label text-small text-muted"
                                                       for="login-remember">Keep me signed in</label>
                                            </div>
                                            <hr>
                                            <div class="text-center text-small text-muted">
                            <span>Don't have an account yet? <a href="#">Create one</a>
                            </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{--                <a href="#" class="btn btn-primary ml-lg-3">Вход / Регистрация</a>--}}

            </div>
        </div>
    </nav>
</div>