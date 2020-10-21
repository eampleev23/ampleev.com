<div class="col-md-8 col-lg-9">


    @for($i=0; $i < count($items); $i++)


        @switch($items[$i]->type_article)
            @case('article')
            <div class="pr-lg-4">
                <div class="card card-article-wide flex-md-row no-gutters">
                    <a href="{{route('blog.show_article',$items[$i]->text_url)}}" class="col-md-4">
                        <img src="{{$items[$i]->main_image_path}}" alt="Image" class="card-img-top">
                    </a>
                    <div class="card-body d-flex flex-column col-auto p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="text-small d-flex">
                                <div class="mr-2">
                                    <a href="{{route('blog.show_blog_section',$last_articles[$i]->blog_section->title)}}">{{$items[$i]->blog_section->title}}</a>
                                </div>
                                <span class="text-muted">{{$items[$i]->get_nice_time_created()}}</span>
                            </div>
                            <span class="badge bg-primary-alt text-primary" data-toggle="tooltip" data-placement="top"
                                  title
                                  data-original-title="Количество уникальных просмотров">
                      <img class="icon icon-sm bg-primary" src="assets/my_svg/Eye_view_views_enable_watch_1886932.svg"
                           alt="heart interface icon" data-inject-svg/>{{$items[$i]->views_count}}
                    </span>
                        </div>
                        <a href="{{route('blog.show_article',$items[$i]->text_url)}}" class="flex-grow-1">
                            <h3>{{$items[$i]->title}}</h3>
                        </a>
                        <div class="d-flex align-items-center mt-3">
                            <img src="{{env('APP_URL').$items[$i]->user->avatar_path}}" alt="Image"
                                 class="avatar avatar-sm">
                            <div class="ml-1">
                                <span class="text-small">{{$items[$i]->user->name}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @break
            @case('link')
            <div class="pr-lg-4">
                <noindex><a rel="nofollow" href="{{$items[$i]->text_url}}"
                            class="card card-body justify-content-between bg-primary text-light">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="text-small d-flex">
                                <div class="mr-2">
                                    Ссылки
                                </div>
                                <span class="opacity-70">{{$items[$i]->get_nice_time_created()}}</span>
                            </div>
                            {{--                        <span class="badge bg-primary-alt text-primary">--}}
                            {{--                    <img class="icon icon-sm bg-primary" src="assets/my_svg/Eye_view_views_enable_watch_1886932.svg"--}}
                            {{--                         alt="heart interface icon" data-inject-svg="">{{$items[$i]->views_count}}--}}
                            {{--                  </span>--}}
                        </div>
                        <div>
                            <h2>{{$items[$i]->title}}</h2>
                            <span class="text-small opacity-70">{{$items[$i]->text_url}}</span>
                        </div>
                    </a></noindex>
            </div>
            @break
            @case('qoute')
            <div class="pr-lg-4">
                <div class="card card-body justify-content-between bg-primary-2 text-light">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="text-small d-flex">
                            <div class="mr-2">
                                <a href="#">Цитаты</a>
                            </div>
                            <span class="opacity-70">{{$items[$i]->get_nice_time_created()}}</span>
                        </div>
                        {{--                        <span class="badge bg-primary text-light">--}}
                        {{--                    <img class="icon icon-sm bg-white" src="assets/my_svg/Eye_view_views_enable_watch_1886932.svg"--}}
                        {{--                         alt="heart interface icon" data-inject-svg="">{{$items[$i]->views_count}}--}}
                        {{--                  </span>--}}
                    </div>
                    <div>
                        <h2>&#171;{{$items[$i]->title}}&#187;</h2>
                        <span class="text-small opacity-70">– {{$items[$i]->first_paragraph}}</span>
                    </div>
                </div>
            </div>
            @break
            @default
            <div></div>
        @endswitch
    @endfor
</div>