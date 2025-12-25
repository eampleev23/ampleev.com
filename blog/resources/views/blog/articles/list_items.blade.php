<div class="col-md-8 col-lg-9">
    @foreach($items as $item)
        @switch($item->type_article)
            @case('article')
            <div class="pr-lg-4">
                <div class="card card-article-wide flex-md-row no-gutters">
                    <a href="{{route('blog.show_article',$item->text_url)}}" class="col-md-4">
                        <img src="{{$item->main_image_path}}" alt="Image" class="card-img-top">
                    </a>
                    <div class="card-body d-flex flex-column col-auto p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="text-small d-flex">
                                <div class="mr-2">
                                    <a href="{{route('blog.show_blog_section', str_replace('/', '_SLASH_', $item->blog_section->title))}}">{{$item->blog_section->short_title_for_display}}</a>
                                </div>
                                <span class="text-muted">{{$item->get_nice_day_created()}}</span>
                            </div>
                            <span class="badge bg-primary-alt text-primary" data-toggle="tooltip" data-placement="top"
                                  title
                                  data-original-title="Количество уникальных просмотров">
                      <img class="icon icon-sm bg-primary mr-1" src="/assets/img/icons/theme/general/visible.svg"
                           alt="visible icon"
                           style="transform: scale(1.3);"
                           data-inject-svg/>{{$item->views_count}}
                    </span>
                        </div>
                        <a href="{{route('blog.show_article',$item->text_url)}}" class="flex-grow-1">
                            <h3>{!!$item->html_title!!}</h3>
                        </a>
                        <div class="d-flex align-items-center mt-3">
                            <img src="{{env('APP_URL').$item->user->avatar_path}}" alt="Image"
                                 class="avatar avatar-sm">
                            <div class="ml-1">
                                <span class="text-small">{{$item->user->name}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @break
            @case('link')
            <div class="pr-lg-4">
                <noindex><a rel="nofollow noopener noreferrer" target="_blank" href="{{$item->text_url}}"
                            class="card card-body justify-content-between bg-primary text-light">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="text-small d-flex">
                                <div class="mr-2">
                                    Ссылки
                                </div>
                                <span class="opacity-70">{{$item->get_nice_day_created()}}</span>
                            </div>
                            <span class="badge bg-primary-alt text-primary" data-toggle="tooltip" data-placement="top"
                                  title
                                  data-original-title="Количество уникальных просмотров">
                                <img class="icon icon-sm bg-primary mr-1" src="/assets/img/icons/theme/general/visible.svg"
                                     alt="visible icon"
                                     style="transform: scale(1.3);"
                                     data-inject-svg/>{{$item->views_count}}
                            </span>
                        </div>
                        <div>
                            <h2>{!!$item->html_title!!}</h2>
                            <span class="text-small opacity-70">{{ \Illuminate\Support\Str::limit($item->text_url, config('blog.link_url_limit', 50)) }}</span>
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
                            <span class="opacity-70">{{$item->get_nice_day_created()}}</span>
                        </div>
                        {{--                        <span class="badge bg-primary text-light">--}}
                        {{--                    <img class="icon icon-sm bg-white" src="assets/my_svg/Eye_view_views_enable_watch_1886932.svg"--}}
                        {{--                         alt="heart interface icon" data-inject-svg="">{{$items[$i]->views_count}}--}}
                        {{--                  </span>--}}
                    </div>
                    <div>
                        <h2>&#171;{!!$item->html_title!!}&#187;</h2>
                        <span class="text-small opacity-70">– {{$item->first_paragraph}}</span>
                    </div>
                </div>
            </div>
            @break
            @default
            <div></div>
        @endswitch
    @endforeach
</div>
