<h5 class="my-4">Всего комментариев: {{$article->get_comments_counter()}}</h5>

<ol class="comments">
    @for($i=0; $i < count($comments); $i++)
        <li class="comment">
            <div class="d-flex align-items-center text-small">

                <img id="comment_first" src="{{$comments[$i]->user->avatar_path}}"
                     alt="Sarah Priestly"
                     class="avatar avatar-sm mr-2">

                <div class="text-dark mr-1">{{$comments[$i]->user->name}}</div>
                <div class="text-muted">{{$comments[$i]->get_nice_time_created()}}</div>
            </div>
            <div class="my-2">
                {{$comments[$i]->content}}
            </div>
            <div>
                @if($i==count($comments)-1)
                    <a id="add_comment" href="#" class="text-small">Ответить</a>
                @else
                    <a href="#" class="text-small">Ответить</a>
                @endif
            </div>
        </li>
    @endfor
</ol>