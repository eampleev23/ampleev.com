<h5 class="my-4">Добавить комментарий</h5>

@auth

    <form action="{{route('media_form.take')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="file" name="path">
        <br/>
        Место
        <select name="place_id">
            @if($active_place==false)
                @foreach($places as $place)
                    <option value="{{$place->id}}">{{$place->name}}</option>
                @endforeach
            @else
                @foreach($places as $place)
                    @if($place->id==$active_place)
                        <option selected="selected" value="{{$place->id}}">{{$place->name}}</option>
                    @else
                        <option value="{{$place->id}}">{{$place->name}}</option>
                    @endif
                @endforeach
            @endif
        </select>
        <br/>
        <br/>
        <button type="submit">Добавить медиа файл</button>
    </form>

    <form action="{{route('add_comment_post')}}" method="post" enctype="multipart/form-data">

        <div class="form-group">
                            <textarea id="add_comment_ta" class="form-control" name="content" rows="7"
                                      placeholder="Вы авторизованы и можете написать комментарий"></textarea>
        </div>
        <div class="d-flex align-items-center justify-content-between">
{{--            <div class="custom-control custom-checkbox">--}}
{{--                <input type="checkbox" class="custom-control-input" id="comment-form-opt-in">--}}
{{--                <label class="custom-control-label text-small" for="comment-form-opt-in">Оповестить меня--}}
{{--                    когда кто-то ответит</label>--}}
{{--            </div>--}}
            <button class="btn btn-primary" type="submit">Отправить</button>
        </div>

    </form>

    <script language="JavaScript">
        if (window.location.href === 'https://ampleev.com/article-1#add_comment') {
            textaria = document.getElementById('add_comment_ta');
            // insertAtCursor(textaria, '')
        }

        function insertAtCursor(myField, myValue) {
            //IE support
            if (document.selection) {
                myField.focus();
                sel = document.selection.createRange();
                sel.text = myValue;
            }
            //MOZILLA and others
            else if (myField.selectionStart || myField.selectionStart == '0') {
                var startPos = myField.selectionStart;
                var endPos = myField.selectionEnd;
                myField.value = myField.value.substring(0, startPos)
                    + myValue
                    + myField.value.substring(endPos, myField.value.length);
            } else {
                myField.value += myValue;
            }
        }
    </script>
@endauth

@guest

    <script language="JavaScript">

        function FbAuth() {
            // if (history.pushState) {
            //     var baseUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
            //     var newUrl = baseUrl + '#add_comment';
            //     history.pushState(null, null, newUrl);
            // } else {
            //     console.warn('History API не поддерживается');
            // }
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
                            <path d="M16.2426 6.34311L6.34309 16.2426C5.95257 16.6331 5.95257 17.2663 6.34309 17.6568C6.73362 18.0473 7.36678 18.0473 7.75731 17.6568L17.6568 7.75732C18.0473 7.36679 18.0473 6.73363 17.6568 6.34311C17.2663 5.95258 16.6331 5.95258 16.2426 6.34311Z"
                                  fill="#212529"></path>
                            <path d="M17.6568 16.2426L7.75734 6.34309C7.36681 5.95257 6.73365 5.95257 6.34313 6.34309C5.9526 6.73362 5.9526 7.36678 6.34313 7.75731L16.2426 17.6568C16.6331 18.0473 17.2663 18.0473 17.6568 17.6568C18.0474 17.2663 18.0474 16.6331 17.6568 16.2426Z"
                                  fill="#212529"></path>
                        </svg>
                    </button>
                    <div class="m-xl-4 m-3">
                        <div class="text-center mb-4">
                            <h4 class="h3 mb-1">Авторизация</h4>
                            <span>Для добавления комментария необходимо авторизоваться</span>
                        </div>
                        <div class="form-group">
                            <button onclick="FbAuth();" class="btn-block btn btn-primary" type="submit">Войти через
                                facebook
                            </button>
                        </div>
                        {{--                        <div class="custom-control custom-checkbox">--}}
                        {{--                            <input type="checkbox" class="custom-control-input" id="signup-agree" checked="checked">--}}
                        {{--                            <label class="custom-control-label text-small text-muted" for="signup-agree">Я согласен с <a--}}
                        {{--                                        href="#">Правилами и условиями использования</a>--}}
                        {{--                            </label>--}}
                        {{--                        </div>--}}
                        {{--                        <hr>--}}
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
