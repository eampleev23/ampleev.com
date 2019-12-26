<ol id="form_for_answer" style="display: none;" class="comments">
    <li class="comment">
        <div class="d-flex align-items-center text-small my-answers">
            @auth
                <img src="{{Auth::user()->avatar_path}}" alt="{{Auth::user()->name}}"
                     class="avatar avatar-sm mr-2">

                <div class="text-dark mr-1">{{Auth::user()->name}}</div>
            @endauth
        </div>
        <form action="{{route('blog.add_comment_post')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="article_id" value={{$article->id}}>
            <input type="hidden" name="comment_id" value="0">
            <div class="form-group">
                            <textarea class="form-control" name="content" rows="7"
                                      style="resize: none;"
                                      placeholder="Напишите что бы вы хотели ответить.."></textarea>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <button class="btn btn-primary" type="submit">Отправить</button>
            </div>
        </form>
    </li>
</ol>



