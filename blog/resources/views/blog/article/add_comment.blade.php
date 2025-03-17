<h5 class="my-4">Добавить комментарий</h5>

@auth

    <form action="{{route('blog.add_comment_post')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="article_id" value={{$article->id}}>
        <input type="hidden" name="article_text_url" value={{$article->text_url}}>
        <input type="hidden" name="comment_id" value=0>
        <div class="form-group">
                            <textarea id="add_comment_ta" class="form-control" name="content" rows="7"
                                      style="resize: none;"
                                      placeholder="Вы авторизованы и можете написать комментарий"></textarea>
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <button class="btn btn-primary" type="submit">Отправить</button>
        </div>

    </form>
@endauth

@guest

    <script language="JavaScript">

        function FbAuth() {
            document.location.href = 'https://ampleev.com/redirect-add_comment'
        }

        function show_modal_sign_in() {
            $('#sign-up-modal').modal()
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
                             class="injected-svg icon bg-dark" data-src="assets/img/icons/interface/cross.svg"
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
                            <button id="VKIDSDKAuthButton" class="VkIdWebSdk__button VkIdWebSdk__button_reset">
                                <div class="VkIdWebSdk__button_container">
                                    <div class="VkIdWebSdk__button_icon">
                                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.54648 4.54648C3 6.09295 3 8.58197 3 13.56V14.44C3 19.418 3 21.907 4.54648 23.4535C6.09295 25 8.58197 25 13.56 25H14.44C19.418 25 21.907 25 23.4535 23.4535C25 21.907 25
           19.418 25 14.44V13.56C25 8.58197 25 6.09295 23.4535 4.54648C21.907 3 19.418 3 14.44 3H13.56C8.58197 3 6.09295 3 4.54648 4.54648ZM6.79999 10.15C6.91798 15.8728 9.92951 19.31 14.8932 19.31H15.1812V16.05C16.989 16.2332 18.3371
           17.5682 18.8875 19.31H21.4939C20.7869 16.7044 18.9535 15.2604 17.8141 14.71C18.9526 14.0293 20.5641 12.3893 20.9436 10.15H18.5722C18.0747 11.971 16.5945 13.6233 15.1803 13.78V10.15H12.7711V16.5C11.305 16.1337 9.39237 14.3538 9.314 10.15H6.79999Z"
                                                  fill="white"/>
                                        </svg>
                                    </div>
                                    <div class="VkIdWebSdk__button_text">
                                        Войти с VK ID
                                    </div>
                                </div>
                            </button>

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
