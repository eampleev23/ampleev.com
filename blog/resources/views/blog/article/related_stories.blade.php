<section class="bg-primary-alt">
    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <h3 class="h2">Возможно, вам будет интересно</h3>
            </div>
        </div>
        <div class="row">

            <div class="col-md-6 col-lg-4 d-flex" data-aos="fade-up" data-aos-delay="100">
                <a rel="nofollow" href="{{$random_link->text_url}}"
                   class="card card-body justify-content-between bg-primary text-light">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="text-small d-flex">
                            <div class="mr-2">
                                Ссылки
                            </div>
                            <span class="opacity-70">{{$random_link->get_nice_time_created()}}</span>
                        </div>
                        <span class="badge bg-primary-alt text-primary">
                                          <img class="icon icon-sm bg-primary"
                                               src="assets/my_svg/Eye_view_views_enable_watch_1886932.svg"
                                               alt="heart interface icon" data-inject-svg/>{{$random_link->views_count}}
                                        </span>
                    </div>
                    <div>
                        <h2>{!!$random_link->html_title!!}</h2>
                        <span class="text-small opacity-70">{{$random_link->text_url}}</span>
                    </div>
                </a>
            </div>

            {{--            @for($i=0; $i < count($random_articles); $i++)--}}
            {{--                <div class="col-md-6 col-lg-4 d-flex" data-aos="fade-up" data-aos-delay="200">--}}
            {{--                    <div class="card">--}}
            {{--                        <a href="{{route('blog.show_article',$random_articles[$i]->text_url)}}">--}}
            {{--                            <img src="{{$random_articles[$i]->main_image_path}}" alt="Image" class="card-img-top">--}}
            {{--                        </a>--}}
            {{--                        <div class="card-body d-flex flex-column">--}}
            {{--                            <div class="d-flex justify-content-between mb-3">--}}
            {{--                                <div class="text-small d-flex">--}}
            {{--                                    <div class="mr-2">--}}
            {{--                                        <a href="#">{{$random_articles[$i]->blog_section->title}}</a>--}}
            {{--                                    </div>--}}
            {{--                                    <span class="text-muted">{{$random_articles[$i]->get_nice_time_created()}}</span>--}}
            {{--                                </div>--}}
            {{--                                <span class="badge bg-primary-alt text-primary">--}}
            {{--                    <img class="icon icon-sm bg-primary" src="assets/my_svg/Eye_view_views_enable_watch_1886932.svg"--}}
            {{--                         alt="heart interface icon" data-inject-svg/>{{$random_articles[$i]->views_count}}--}}
            {{--                  </span>--}}
            {{--                            </div>--}}
            {{--                            <a href="{{route('blog.show_article',$random_articles[$i]->text_url)}}">--}}
            {{--                                <h4>{{$random_articles[$i]->title}}</h4>--}}
            {{--                            </a>--}}
            {{--                            <p class="flex-grow-1">--}}
            {{--                                {{$random_articles[$i]->seo_description}}--}}
            {{--                            </p>--}}
            {{--                            <div class="d-flex align-items-center mt-3">--}}
            {{--                                <img src="{{env('APP_URL').$random_articles[$i]->user->avatar_path}}" alt="Image"--}}
            {{--                                     class="avatar avatar-sm">--}}
            {{--                                <div class="ml-1">--}}
            {{--                                    <span class="text-small">{{$random_articles[$i]->user->name}}</span>--}}
            {{--                                </div>--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            @endfor--}}
        </div>
    </div>
</section>
