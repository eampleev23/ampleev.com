<h5 class="my-4">Добавить комментарий</h5>

@auth

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form id="comment-form" action="{{route('blog.add_comment_post')}}" method="post" enctype="multipart/form-data" data-metrika-comment-form>
        @csrf
        <input type="hidden" name="article_id" value="{{$article->id}}">
        <input type="hidden" name="article_text_url" value="{{$article->text_url}}">
        <input type="hidden" name="comment_id" value="0">
        <div class="form-group">
            <textarea id="add_comment_ta" 
                      class="form-control @error('content') is-invalid @enderror" 
                      name="content" 
                      rows="7"
                                      style="resize: none;"
                      placeholder="Вы авторизованы и можете написать комментарий"
                      minlength="3"
                      maxlength="5000"
                      required>{{ old('content') }}</textarea>
            @error('content')
                <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror
            <small class="form-text text-muted">
                <span id="comment-length-counter">0</span> / 5000 символов (минимум 3)
            </small>
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <div id="comment-error-message" class="text-danger small" style="display: none;"></div>
            <button id="comment-submit-btn" class="btn btn-primary" type="submit" disabled>Отправить</button>
        </div>
    </form>

    <script>
        (function() {
            var textarea = document.getElementById('add_comment_ta');
            var submitBtn = document.getElementById('comment-submit-btn');
            var counter = document.getElementById('comment-length-counter');
            var errorMessage = document.getElementById('comment-error-message');
            var form = document.getElementById('comment-form');
            
            if (!textarea || !submitBtn || !counter) return;
            
            // Функция для подсчета символов (без учета пробелов в начале/конце)
            function updateCommentValidation() {
                var text = textarea.value.trim();
                var length = text.length;
                
                // Обновляем счетчик
                counter.textContent = length;
                
                // Проверяем валидность
                var isValid = length >= 3 && length <= 5000;
                
                // Обновляем состояние кнопки
                submitBtn.disabled = !isValid;
                
                // Показываем/скрываем сообщение об ошибке
                if (length > 0 && !isValid) {
                    if (length < 3) {
                        errorMessage.textContent = 'Комментарий должен содержать минимум 3 символа';
                        errorMessage.style.display = 'block';
                    } else if (length > 5000) {
                        errorMessage.textContent = 'Комментарий не может быть длиннее 5000 символов';
                        errorMessage.style.display = 'block';
                    }
                } else {
                    errorMessage.style.display = 'none';
                }
                
                // Обновляем стиль счетчика
                if (length > 5000) {
                    counter.style.color = '#dc3545'; // красный
                } else if (length >= 3) {
                    counter.style.color = '#28a745'; // зеленый
                } else {
                    counter.style.color = '#6c757d'; // серый
                }
            }
            
            // Обработчики событий
            textarea.addEventListener('input', updateCommentValidation);
            textarea.addEventListener('paste', function() {
                setTimeout(updateCommentValidation, 10);
            });
            
            // Инициализация при загрузке
            updateCommentValidation();
            
            // Проверяем, нужно ли установить фокус на textarea после авторизации
            if (window.location.hash === '#add_comment') {
                // Предотвращаем автоматический скролл браузера к якорю
                if (history.replaceState) {
                    history.replaceState(null, null, window.location.pathname + window.location.search);
                }
                
                // Прокручиваем страницу вверх
                window.scrollTo(0, 0);
                
                // Небольшая задержка для гарантии, что страница полностью загружена
                setTimeout(function() {
                    var commentSection = document.querySelector('h5.my-4');
                    
                    if (commentSection && textarea) {
                        // Вычисляем позицию заголовка с учетом отступа сверху
                        var headerOffset = 100;
                        var elementPosition = commentSection.getBoundingClientRect().top;
                        var offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                        
                        // Плавно прокручиваем к заголовку с отступом
                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });
                        
                        // После завершения скролла устанавливаем фокус на textarea
                        setTimeout(function() {
                            textarea.focus();
                            if (sessionStorage.getItem('focus_comment_input') === 'true') {
                                sessionStorage.removeItem('focus_comment_input');
                            }
                        }, 800);
                    }
                }, 100);
            }
            
            // Если есть ошибки валидации, прокручиваем к форме
            @if($errors->has('content') || session('error'))
                setTimeout(function() {
                    form.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    textarea.focus();
                }, 100);
            @endif
        })();
    </script>
@endauth

@guest

    <script>
        // console.log("here at start script")

        // function FbAuth() {
        //     document.location.href = 'https://ampleev.com/redirect-add_comment'
        // }
        //
        function show_modal_sign_in() {
            // Сохраняем флаг, что пользователь кликнул на textarea для комментария
            // Это будет использовано после авторизации для установки фокуса
            sessionStorage.setItem('focus_comment_input', 'true');
            $('#sign-up-modal').modal()

            // const VKID = window.VKIDSDK;
            //
            // VKID.Config.init({
            //     app: 53261431, // Идентификатор приложения.
            //     redirectUrl: 'https://ampleev.com/redirect-vk', // Адрес для перехода после авторизации.
            //     state: 'ghJxyj', // Произвольная строка состояния приложения.
            //     codeVerifier: 'RBxL6f', // Параметр в виде случайной строки. Обеспечивает защиту передаваемых данных.
            //     scope: 'vkid.personal_info', // Список прав доступа, которые нужны приложению.
            // });
            //
            // // Обработчик клика.
            // const handleClick = () => {
            //     // Открытие авторизации.
            //     VKID.Auth.login()
            // }
            //
            // // Получение кнопки из разметки.
            // const button = document.getElementById('VKIDSDKAuthButton');
            // // Проверка наличия кнопки в разметке.
            // if (button) {
            //     // Добавление обработчика клика по кнопке.
            //     button.onclick = handleClick;
            // }
        }


    </script>

    <div class="form-group">
        <textarea onclick="show_modal_sign_in();" class="form-control" name="comment-text" rows="7"
                  placeholder="Ваш комментарий"></textarea>
    </div>

    <div class="d-flex align-items-center justify-content-between">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="comment-form-opt-in">
            <label class="custom-control-label text-small" for="comment-form-opt-in">Оповестить меня
                когда кто-то ответит</label>
        </div>
        <button class="btn btn-primary">Отправить</button>
    </div>

    <div class="modal fade" id="sign-up-modal" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             class="injected-svg icon bg-dark" data-src="/assets/img/icons/interface/cross.svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path
                                d="M16.2426 6.34311L6.34309 16.2426C5.95257 16.6331 5.95257 17.2663 6.34309 17.6568C6.73362 18.0473 7.36678 18.0473 7.75731 17.6568L17.6568 7.75732C18.0473 7.36679 18.0473 6.73363 17.6568 6.34311C17.2663 5.95258 16.6331 5.95258 16.2426 6.34311Z"
                                fill="#212529"></path>
                            <path
                                d="M17.6568 16.2426L7.75734 6.34309C7.36681 5.95257 6.73365 5.95257 6.34313 6.34309C5.9526 6.73362 5.9526 7.36678 6.34313 7.75731L16.2426 17.6568C16.6331 18.0473 17.2663 18.0473 17.6568 17.6568C18.0474 17.2663 18.0474 16.6331 17.6568 16.2426Z"
                                fill="#212529"></path>
                        </svg>
                    </button>
                    <div class="m-xl-4 m-3">
                        <div class="text-center mb-4">
                            <h4 class="h3 mb-1">Авторизация</h4>
                            <span>Для добавления комментария необходимо авторизоваться</span>
                        </div>
                        <div class="form-group">
                            {{--                            <button onclick="FbAuth();" class="btn-block btn btn-primary" type="submit">Войти через--}}
                            {{--                                facebook--}}
                            {{--                            </button>--}}
                            <button onclick="location.href='{{route('yandex', ['redirect_to' => url()->current() . '#add_comment'])}}'" class="btn-block btn btn-primary"
                                    type="submit">Войти через
                                yandex
                            </button>

                            {{--                            <button id="VKIDSDKAuthButton" class="VkIdWebSdk__button VkIdWebSdk__button_reset">--}}
                            {{--                                <div class="VkIdWebSdk__button_container">--}}
                            {{--                                    <div class="VkIdWebSdk__button_icon">--}}
                            {{--                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none"--}}
                            {{--                                             xmlns="http://www.w3.org/2000/svg">--}}
                            {{--                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.54648 4.54648C3 6.09295 3 8.58197 3 13.56V14.44C3 19.418 3 21.907 4.54648 23.4535C6.09295 25 8.58197 25 13.56 25H14.44C19.418 25 21.907 25 23.4535 23.4535C25 21.907 25--}}
                            {{--           19.418 25 14.44V13.56C25 8.58197 25 6.09295 23.4535 4.54648C21.907 3 19.418 3 14.44 3H13.56C8.58197 3 6.09295 3 4.54648 4.54648ZM6.79999 10.15C6.91798 15.8728 9.92951 19.31 14.8932 19.31H15.1812V16.05C16.989 16.2332 18.3371--}}
                            {{--           17.5682 18.8875 19.31H21.4939C20.7869 16.7044 18.9535 15.2604 17.8141 14.71C18.9526 14.0293 20.5641 12.3893 20.9436 10.15H18.5722C18.0747 11.971 16.5945 13.6233 15.1803 13.78V10.15H12.7711V16.5C11.305 16.1337 9.39237 14.3538 9.314 10.15H6.79999Z"--}}
                            {{--                                                  fill="white"/>--}}
                            {{--                                        </svg>--}}
                            {{--                                    </div>--}}
                            {{--                                    <div class="VkIdWebSdk__button_text">--}}
                            {{--                                        Войти с VK ID--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </button>--}}
                        </div>
                        <div class="text-center text-small text-muted">
                                <span>Изучите наши <a target="_blank"
                                                      href="{{route('docs.terms_of_use')}}">Пользовательское соглашение</a> и <a
                                        target="_blank"
                                        href="{{route('docs.terms_of_use')."#support"}}">Политику Конфиденциальности</a>. Регистрируясь или авторизуясь, вы автоматически соглашаетесь с ними.
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endguest
