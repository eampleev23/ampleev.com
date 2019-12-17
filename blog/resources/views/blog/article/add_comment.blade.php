<h5 class="my-4">Добавить комментарий</h5>

@auth
    <form>
        <div class="form-group">
                            <textarea class="form-control" name="comment-text" rows="7"
                                      placeholder="Комментарий"></textarea>
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="comment-form-opt-in">
                <label class="custom-control-label text-small" for="comment-form-opt-in">Оповестить меня
                    когда кто-то ответит</label>
            </div>
            <button class="btn btn-primary" type="submit">Отправить</button>
        </div>
    </form>
@endauth

@guest

    <script language="JavaScript">

        function hrefToFbAuth() {
            //window.location.replace("https://ampleev.com/redirect");
            document.location.href = 'https://ampleev.com/redirect'
        }

    </script>

    <div class="form-group">
                            <textarea onclick="hrefToFbAuth()" class="form-control" name="comment-text" rows="7"
                                      placeholder="Комментарий"></textarea>
    </div>
    <div class="d-flex align-items-center justify-content-between">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="comment-form-opt-in">
            <label class="custom-control-label text-small" for="comment-form-opt-in">Оповестить меня
                когда кто-то ответит</label>
        </div>
        <button class="btn btn-primary">Отправить</button>
    </div>

@endguest
