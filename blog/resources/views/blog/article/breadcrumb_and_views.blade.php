<section class="pb-0 pb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('blog.blog')}}">Блог</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{route('blog.show_blog_section', urlencode($article->blog_section->title))}}">{{$article->blog_section->title}}</a>
                            </li>
                        </ol>
                    </nav>
                    <span class="badge bg-primary-alt text-primary" data-toggle="tooltip" data-placement="top" title
                          data-original-title="Количество уникальных просмотров">
                <img class="icon icon-sm bg-primary mr-1"
                     src="/assets/img/icons/theme/general/visible.svg"
                     alt="visible icon"
                     style="transform: scale(1.3);"
                     data-inject-svg/>{{$article->views_count}}</span>
                </div>
                <h1>{!!$article->html_title!!}</h1>
                <div class="d-flex align-items-center">
                    <a href="#">
                        <img src="{{env('APP_URL').$article->user->avatar_path}}" alt="Avatar" class="avatar mr-2">
                    </a>
                    <div>
                        <div>Автор статьи: <a href="#">{{$article->user->name}}</a>
                        </div>
                        <div class="text-small text-muted">{{$article->get_nice_time_created()}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
