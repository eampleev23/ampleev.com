<h5 class="my-4">Добавить комментарий</h5>

@auth
    <form>
        <div class="form-group">
                            <textarea id="add_comment_ta" class="form-control" name="comment-text" rows="7"
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
    <script language="JavaScript">
        if (window.location.href === 'https://ampleev.com/article-1#add_comment') {
            textaria = document.getElementById('add_comment_ta');
            console.log(textaria)
        }
    </script>
@endauth

@guest

    <script language="JavaScript">

        function hrefToFbAuth() {
            if (history.pushState) {
                var baseUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                var newUrl = baseUrl + '#add_comment';
                history.pushState(null, null, newUrl);
            } else {
                console.warn('History API не поддерживается');
            }
            redirectToFBAuth();

        }

        function redirectToFBAuth() {
            document.location.href = 'https://ampleev.com/redirect-add_comment'
        }

    </script>

    <div class="form-group">
                            <textarea onclick="setTimeout(hrefToFbAuth, 1000);" class="form-control" name="comment-text"
                                      rows="7"
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
